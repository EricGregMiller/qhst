// *************************
// Construct beginning of page
// *************************
document.writeln('<table width="100%" border="0" cellspacing="0" cellpadding="0">');
document.writeln('  <tr> ');
document.writeln('    <td colspan="2" background="' + gButtonImagePath + 'topbg.jpg"><img src="' + gButtonImagePath + 'top3.jpg" width="383" height="92"></td>');
document.writeln('  </tr>');
document.writeln('  <tr> ');
document.writeln('    <td width="11%" background="' + gButtonImagePath + 'left.jpg" valign="top"> ');
document.writeln('      <p><img src="' + gButtonImagePath + 'lefttop3.jpg" width="151" height="134"><br>');
for (iiButton=1; iiButton<=gButtonRef.length; iiButton++)
  document.writeln('        <a href=' + GetButtonHref(iiButton) + ' onMouseOver="ChangeButtonImage(this,' + iiButton + ',\'on\')" onMouseOut="ChangeButtonImage(this,' + iiButton + ')"><img src=' + GetButtonImageFile(iiButton) + ' width="151" height="33" border="0"></A><br>');
document.writeln('        <img src="' + gButtonImagePath + 'bot.jpg" width="151" height="60"><br>');
document.writeln('      </p>');
document.writeln('      <p>&nbsp;</p>');
document.writeln('      <p>&nbsp;</p>');
document.writeln('      <p>&nbsp;</p>');
document.writeln('      <p>&nbsp;</p>');
document.writeln('      <p>&nbsp; </p>');
document.writeln('    </td>');
document.writeln('    <td width="95%" valign="top"> ');
