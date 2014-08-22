// *************************
// Construct beginning of page
// *************************
document.writeln('<table width="100%" border="0" cellspacing="0" cellpadding="0">');
document.writeln('  <tr> ');
document.writeln('    <td colspan="2" background="/Master/topbg.jpg"><a href="/QHCC/church.htm"><img src="/Master/QHCCTop.jpg" width="383" height="92" border="0"></a></td>');
document.writeln('  </tr>');
document.writeln('  <tr> ');
document.writeln('    <td width="11%" background="/Master/left.jpg" valign="top"> ');
document.writeln('      <p><a href="/QHCC/church.htm"><img src="/Master/QHCCLeftTop.jpg" width="151" height="134" border="0"></a><br>');
for (iiButton=1; iiButton<=11; iiButton++)
  document.writeln('        <a href="' + GetButtonHref(iiButton) + '" onMouseOver="ChangeButtonImage(this,' + iiButton + ',\'on\')" onMouseOut="ChangeButtonImage(this,' + iiButton + ')"><img src=' + GetButtonImageFile(iiButton) + ' width="151" height="33" border="0"></A><br>');
  document.writeln('        <a href="' + GetButtonHref(15) + '" onMouseOver="ChangeButtonImage(this,15,\'on\')" onMouseOut="ChangeButtonImage(this,15)"><img src=' + GetButtonImageFile(15) + ' width="151" height="33" border="0"></A><br>');
document.writeln('        <img src="/Master/bot.jpg" width="151" height="60"><br>');
document.writeln('      </p>');
document.writeln('      <p>&nbsp;</p>');
document.writeln('      <p>&nbsp;</p>');
document.writeln('      <p>&nbsp;</p>');
document.writeln('      <p>&nbsp;</p>');
document.writeln('      <p>&nbsp; </p>');
document.writeln('    </td>');
document.writeln('    <td width="95%" valign="top"> ');
