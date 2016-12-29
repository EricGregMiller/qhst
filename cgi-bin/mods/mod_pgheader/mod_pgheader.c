/* snips out body tags and inserts a per-directory head/foot
 * In <Directory> section: AddBodyHead  full_path_to_header  apply_to_full_path/*
 *                         AddBodyFoot  full_path_to_footer  apply_to_full_path/*
 * Can have multiple directives, longest matches first.
 * (adapted from mod_include; for Apache 2.2 )
 * $Id: mod_pgheader.c,v 1.2 2006/06/17 15:49:35 plandart Exp $
*/

#include "httpd.h"
#include "http_core.h"
#include "http_config.h"
#include "http_log.h"
#include "apr_strings.h"
#include "apr_general.h"
#include "util_filter.h"
#include "apr_buckets.h"
#include "http_request.h"
#define APR_WANT_STRFUNC
#include "apr_want.h"




/*
 * +-------------------------------------------------------+
 * |                                                       |
 * |                 Types and Structures
 * |                                                       |
 * +-------------------------------------------------------+
 */

#define isone(c)    (c=='<')
#define istwo(c)   ( (c=='B') || (c=='/')  )
#define isthree(c)   ( (c=='O') || (c=='B') )
#define isfour(c)   ( (c=='D') || (c=='O')  )
#define isfive(c)   ( (c=='Y') || (c=='D')  )
/* isfive yields finalval:
 * Y=89=STARTBODY
 * D=68=ENDBODY
 */


#define REVBITHACK	1

#define MISMATCH_SIZE	5
char mismatch[MISMATCH_SIZE];


typedef struct {
	apr_array_header_t *bodyhd_list, *bodyft_list;
} pgheader_dir_config;





struct item {
	char *apply_path;
	char *data;
};




typedef struct pgheader_ctx_t {

	/* permanent pool, use this for creating bucket data */
	apr_pool_t  *pool;


	/* if true, the current buffer will be passed down the filter chain before
	 * continuing with next input bucket and the variable will be reset to
	 * false.
	 */
	int          flush_now;

	int           go_on;
   int           finalval;
   int           seen_eos;
   int           error;
   int			insert_header;	/* if time to insert a header/footer */
	int			tag_open;				
   apr_size_t    bytes_read;
   apr_size_t    dump_to_here;
   apr_size_t    release;
	request_rec  *r;


} pgheader_ctx_t;



/*
 * +-------------------------------------------------------+
 * |                                                       |
 * |                 Static Module Data
 * |                                                       |
 * +-------------------------------------------------------+
 */

/* global module structure */
module AP_MODULE_DECLARE_DATA pgheader_module;


#define STARTBODY 89
#define ENDBODY 68
#define NONE -1



char * find_body_item(request_rec *r, apr_array_header_t *list) {

	char *path = r->filename;
	char * empty="";

	struct item *items = (struct item *)list->elts;
	int i;

	for (i = 0; i < list->nelts; ++i) {
	    struct item *p = &items[i];


/* Match = 0, NoMatch = 1, Abort = -1 */
	    if(!ap_strcmp_match(path,p->apply_path)) {
				return p->data;
	    }
	}
	return empty;
}






/*
 * </*body.*>
 */
static apr_status_t handle_head(pgheader_ctx_t *ctx, ap_filter_t *f,
	                               apr_bucket_brigade *bb)
{
	request_rec *r = f->r;
	char * bh = NULL;
	request_rec *rr = NULL;
	char *error_fmt = NULL;

	pgheader_dir_config *conf = ap_get_module_config(f->r->per_dir_config, &pgheader_module);

	if(ctx->finalval==STARTBODY) {
		bh = find_body_item(r,conf->bodyhd_list);
	} else if(ctx->finalval==ENDBODY) {
		bh = find_body_item(r,conf->bodyft_list);
	} else {
		error_fmt = "no body tags found cannot include \"%s\" in parsed file %s";
	}    


	if(bh==NULL) {
		error_fmt = "bh is NULL, cannot include \"%s\" in parsed file %s";
	} else {
		rr = ap_sub_req_lookup_file(bh, r, f->next);


	  if ( rr->status == HTTP_OK && rr->finfo.filetype == APR_REG) {
	     ap_set_module_config(rr->request_config, &pgheader_module, r); /* the kludge, see includes filter */
			rr->subprocess_env = r->subprocess_env;
			apr_pool_join(r->pool, rr->pool);
			rr->finfo.mtime = r->finfo.mtime; 
	   	if (!error_fmt && ap_run_sub_req(rr)) {
	       	error_fmt = "runrequest is unable to include \"%s\" in parsed file %s";
	   	}
			ap_destroy_sub_req(rr);
		} else {
			error_fmt = "file not found, cannot include \"%s\" in parsed file %s";
		}
	}

   if (error_fmt) {
      ap_log_rerror(APLOG_MARK, APLOG_ERR, 0, r, error_fmt, bh, r->filename);
	}

	return APR_SUCCESS;
}














/*
 * +-------------------------------------------------------+
 * |                                                       |
 * |               Main Filter Engine
 * |                                                       |
 * +-------------------------------------------------------+
 */


/* this uses macros instead of bndm_compiling a pattern,
because <body> tags must be case-insensitive, also can search
simultaneously for different strings */

static apr_size_t find_start_macro(request_rec *r, 
		pgheader_ctx_t *ctx, 
		const char *data,
		apr_size_t len )
{


	apr_size_t index = 0;
	int finalval = NONE;
	char c; int i;
	long int k=0;
	int partial=0;

	const char *p, *ep, *sp;
   apr_size_t slen;

	int go_on=ctx->go_on;

 	const char *pi ;
	pi = data - 1; /* pi: p initial */

	if (go_on > 0 && go_on < 5) {
		partial=1;
	}

	slen=0;   
	ep = data + len;
	p = data;


	if(ctx->tag_open) {  /* scan ahead for the '>' */
			while (*p != '>') { ++p; slen++; }
			if (*p == '>') ctx->tag_open=0;
			index =  p - pi ;
			ctx->dump_to_here= slen;	
			return index;
	}


	index=len;		/* adjust in case of matches below */

	while (p < ep) {
		c = *p;

  		switch(go_on) {   
			case 0: if(isone(c))  go_on+=1; else go_on=0; break;   
			case 1: if(istwo(toupper(c)))  go_on+=1; else go_on=0; break;   
			case 2: if(isthree(toupper(c)))  go_on+=1; else go_on=0;  break;   
			case 3: if(isfour(toupper(c)))   go_on+=1; else go_on=0;  break;   
			case 4: if(isfive(toupper(c)))   go_on+=1; else go_on=0;  break;   
			default: break;   
		}   
		if(isone(c)) sp=p;

		if (go_on == 5) {
	 		finalval=(int)(toupper(c));
			ctx->tag_open=1;
   		slen = (apr_size_t)go_on;
			index = p - pi - slen ;

			while (*p != '>') {
				++p; 
				slen++;
			}
			if (*p == '>') ctx->tag_open=0;

			ctx->dump_to_here= slen;	

			if (partial) { index=0; ctx->dump_to_here=p-pi; ctx->release=0; }

			ctx->finalval=finalval;
			go_on=0;
			break;
		}

		++p;
   } /* end while */


	if( go_on > 0  && go_on < 5 ) {
   	slen = (apr_size_t)go_on;
		index = p - pi - slen -1 ; /* cf last increment of p */
		for (i=0;i<go_on;i++) --p;
		strncpy(mismatch,p,go_on);
		ctx->dump_to_here= slen;	
		ctx->release=slen;
	}

	ctx->go_on=go_on;
	return index;

}





/*
 * This is the main loop over the current bucket brigade.
 */

static apr_status_t send_page(ap_filter_t *f, apr_bucket_brigade *bb)
{

	pgheader_ctx_t *ctx = f->ctx;
	request_rec *r = f->r;

	apr_bucket *b = APR_BRIGADE_FIRST(bb);
	apr_status_t rv = APR_SUCCESS;
	apr_bucket_brigade *pass_bb;

	apr_size_t r_len;

	/* Loop through the brigade and pass out each bucket as soon as read */
	/* All stuff passed along has to be put into the pass_bb brigade */

	pass_bb = apr_brigade_create(ctx->pool, f->c->bucket_alloc);

	

	/* initialization for this loop */
	ctx->bytes_read = 0;
	ctx->error = 0;
	ctx->dump_to_here = 0;
	ctx->flush_now = 0;
	ctx->release = 0;

	memset(mismatch,'\0',sizeof(mismatch));
	



	while (b != APR_BRIGADE_SENTINEL(bb) ) {
		const char *data = NULL;
		apr_size_t len, index, release;
		apr_bucket *newb = NULL;

		/* handle meta buckets before reading any data */
		if (APR_BUCKET_IS_METADATA(b)) {
			newb = APR_BUCKET_NEXT(b);
			APR_BUCKET_REMOVE(b);
			if (APR_BUCKET_IS_EOS(b)) {
				ctx->seen_eos = 1;
				if (ctx->insert_header) { 
					handle_head(ctx, f, bb);
					APR_BUCKET_INSERT_BEFORE(newb, b);
				} else {
					break; /* END OF STREAM */
				}
			} else {
				APR_BRIGADE_INSERT_TAIL(pass_bb, b);
				if (APR_BUCKET_IS_FLUSH(b)) {
					ctx->flush_now = 1;
				}
				b = newb;
				continue;
			}
		}
	


		/* ./include/http_core.h:126:#define AP_MIN_BYTES_TO_WRITE  8000 */
		if (ctx->flush_now || ctx->bytes_read > AP_MIN_BYTES_TO_WRITE) {
			if (!APR_BRIGADE_EMPTY(pass_bb)) {
				rv = ap_pass_brigade(f->next, pass_bb);

				if (rv != APR_SUCCESS) {
					apr_brigade_destroy(pass_bb);
					return rv;
				}
			}
			ctx->flush_now = 0;
			ctx->bytes_read = 0;
		}


		if(ctx->insert_header) {
			handle_head(ctx, f, bb);
			ctx->insert_header = 0;
		}


		/* read the current bucket's data */
		len = 0;
		if (!ctx->seen_eos) {
			if (ctx->bytes_read > 0) {
				rv = apr_bucket_read(b, &data, &len, APR_NONBLOCK_READ); 
				if (APR_STATUS_IS_EAGAIN(rv)) {
					ctx->flush_now = 1;
					continue;
				}
			}
			if (!len || rv != APR_SUCCESS) {
				rv = apr_bucket_read(b, &data, &len, APR_BLOCK_READ);
			}

			if (rv != APR_SUCCESS) {
				apr_brigade_destroy(pass_bb);
				return rv;
			}

			ctx->bytes_read += len;
		}


	   /* zero length bucket, fetch next one */
	    if (!len && !ctx->seen_eos) {
	        b = APR_BUCKET_NEXT(b);
	        continue;
	    }


		/* now look for a body tag */


		index = find_start_macro(r, ctx, data, len); 


		if ( (index == len) && (ctx->release>0)  ) {

			char *to_release = apr_palloc(ctx->pool, ctx->release);
			strncpy(to_release, mismatch, ctx->release);


			APR_BRIGADE_INSERT_TAIL(pass_bb,
				apr_bucket_pool_create(to_release, 
				ctx->release, ctx->pool, f->c->bucket_alloc));

			ctx->release = 0;
			memset(to_release, '\0', MISMATCH_SIZE);




		}




		if (index < len) {
			apr_bucket_split(b, index);
		}

		newb = APR_BUCKET_NEXT(b);
		APR_BUCKET_REMOVE(b);
		APR_BRIGADE_INSERT_TAIL(pass_bb, b);	/* put this first bit in the out brigade */

		if (index < len) {
			if ( ctx->finalval == STARTBODY || ctx->finalval == ENDBODY   ) {
					apr_bucket_split(newb, ctx->dump_to_here);  
					ctx->flush_now = 1; 
					ctx->insert_header = 1;
			}
			b = APR_BUCKET_NEXT(newb);
			apr_bucket_delete(newb);
		} else {
			b = newb;
		}

	} /* end while */



   if (ctx->seen_eos) {
		/* don't forget to finally insert the EOS bucket */
		APR_BRIGADE_INSERT_TAIL(pass_bb, b);
	}

	/* if something's left over, pass it along */
	if (!APR_BRIGADE_EMPTY(pass_bb)) {
	    rv = ap_pass_brigade(f->next, pass_bb);
	} else {
	    rv = APR_SUCCESS;
	    apr_brigade_destroy(pass_bb);
	}
	return rv;
}





















/*
 * +-------------------------------------------------------+
 * |                                                       |
 * |                     Runtime Hooks
 * |                                                       |
 * +-------------------------------------------------------+
 */

static int pgheader_setup(ap_filter_t *f)
{
	pgheader_dir_config *conf = ap_get_module_config(f->r->per_dir_config,
	                                                &pgheader_module);


	/* Don't allow ETag headers to be generated - see RFC2616 - 13.3.4.
	 * We don't know if we are going to be including a file or executing
	 * a program - in either case a strong ETag header will likely be invalid.
	 */
	apr_table_setn(f->r->notes, "no-etag", "");

	return OK;
}














static apr_status_t pgheader_filter(ap_filter_t *f, apr_bucket_brigade *bb)
{
	request_rec *r = f->r;
	pgheader_ctx_t *ctx = f->ctx;
	pgheader_dir_config *conf = ap_get_module_config(r->per_dir_config, &pgheader_module);





#ifdef REVBITHACK
	      if (r->finfo.protection & APR_FPROT_GEXECUTE) {
   			ap_remove_output_filter(f) ;
   			return ap_pass_brigade(f->next, bb) ;
      	}
#endif
#ifdef USEBITHACK
	      if (r->finfo.protection & !APR_FPROT_GEXECUTE) {
   			ap_remove_output_filter(f) ;
   			return ap_pass_brigade(f->next, bb) ;
      	}
#endif

	/* at least make sure we are likely to find body tags */
	if (!r->content_type || strcmp(r->content_type, "text/html")) {
            ap_remove_output_filter(f) ;
            return ap_pass_brigade(f->next, bb) ;
	}








	if (!f->ctx) {

	    /* create context for this filter */
	    f->ctx = ctx = apr_palloc(r->pool, sizeof(*ctx));
	    ctx->pool = r->pool;

	    ctx->seen_eos = 0;
	    ctx->insert_header = 0;
	    ctx->go_on = 0;
	    ctx->tag_open = 0;
	}




	/* Always unset the content-length, headers are SSIable */
	apr_table_unset(f->r->headers_out, "Content-Length");

	return send_page(f, bb);

}


















/* ------------------------ Init functions------------------------ */






void push_pgheader_item(apr_array_header_t *arr, const char *to, const char *data)
{
	struct item *p = (struct item *)apr_array_push(arr);

	p->data = data ? apr_pstrdup(arr->pool, data): NULL;
	p->apply_path = apr_pstrcat(arr->pool, to, NULL);
	
}


static const char *add_bodyft(cmd_parms *cmd, void *d, const char *ftfname, const char *to)
{


 push_pgheader_item(((pgheader_dir_config *)d)->bodyft_list,  to,  ftfname);

 return NULL;
}




static const char *add_bodyhd(cmd_parms *cmd, void *d, const char *hdfname, const char *to)
{
	pgheader_dir_config *conf = d;

 push_pgheader_item( conf->bodyhd_list, to, hdfname); 

 return NULL;
}

















/*
 * +-------------------------------------------------------+
 * |                                                       |
 * |                Configuration Handling
 * |                                                       |
 * +-------------------------------------------------------+
 */

static void *create_pgheader_dir_config(apr_pool_t *p, char *dummy)
{
	pgheader_dir_config *result = apr_palloc(p, sizeof(pgheader_dir_config));

	result->bodyhd_list = apr_array_make (p, 4, sizeof (struct item));
	result->bodyft_list = apr_array_make (p, 4, sizeof (struct item));

	return result;
}







/*
 * +-------------------------------------------------------+
 * |                                                       |
 * |        Module Initialization and Configuration
 * |                                                       |
 * +-------------------------------------------------------+
 */





static const command_rec pgheader_cmds[] =
{
	AP_INIT_TAKE2("AddBodyHead", add_bodyhd, NULL, OR_INDEXES, 
			"a header markup file followed by a path"), 

	AP_INIT_TAKE2("AddBodyFoot", add_bodyft, NULL, OR_INDEXES,
	      "a footer markup file followed by a path"),
	{NULL}
};











static void register_hooks(apr_pool_t *p)
{
	ap_register_output_filter("PGHEADER", pgheader_filter, pgheader_setup, AP_FTYPE_RESOURCE);
}







module AP_MODULE_DECLARE_DATA pgheader_module =
{
	STANDARD20_MODULE_STUFF,
	create_pgheader_dir_config,   /* dir config creater */
	NULL,                         /* dir merger --- default is to override */
	NULL,								/* server config, none for PGHEADER, should be per-directory */
	NULL,                         /* merge server config */
	pgheader_cmds,                /* command apr_table_t */
	register_hooks                /* register hooks */
};


