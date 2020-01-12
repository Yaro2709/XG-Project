<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div id='header_top'><center>
<table class='header'>
<tr class='header' >
<td class='header' style='width:5;' >
	  <table class='header'>
    <tr class='header'>
     <td class='header'><img src="{dpath}planeten/small/s_{image}.jpg" height="50" width="50"></td>
     <td class='header'>
	  <table class='header'>

                    <select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
                    {planetlist}
                    </select>
	  </table>
     </td>
    </tr>
  </table></td>
<td class='header'>   <table class='header' id='resources' border="0" cellspacing="0" cellpadding="0" padding-right='30' >

	    <tr class='header'>
	    
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/metall.gif" width="42" height="22">
		     </td>
		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/kristall.gif" width="42" height="22">
		     </td>
		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/deuterium.gif" width="42" height="22">
		     </td>
			 
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/energie.gif" width="42" height="22">
		     </td>
	     		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/darkmatter.jpg" width="42" height="22" title="Dark Matter">
		     </td>	     
	        		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/message.gif" width="42" height="22">
		     </td>

	    </tr>
        
	    <tr class='header'>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Metal}</font></b></i></td>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Crystal}</font></b></i></td>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Deuterium}</font></b></i></td>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Energy}</font></b></i></td>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Darkmatter}</font></b></i></td>		
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Messages}</font></b></i></td>			 
	    </tr>
		
	    <tr class='header'>
	     <td align="center" class='header' width="90"><font ><div id="metal"></div></font></td>
	     <td align="center" class='header' width="90"><div id="crystal"></td>
	     <td align="center" class='header' width="90"><font ><div id="deut"></div></font></td>
	     <td align="center" class='header' width="90">{energy}</td>
	     <td align="center" class='header' width="90"><font color="#FFFFFF">{darkmatter}</font></td>	        
         <td align="center" class='header' width="90">{message}</td>


	    </tr>
   </table></td>
</tr>
</table>
{show_umod_notice}
</div>

<script LANGUAGE='JavaScript'>
<!--
var now = new Date();
var event = new Date();
var seconds = (Date.parse(now) - Date.parse(event)) / 1000;
var val = 0;
var val2 = 0;
var val3 = 0;

update();

function update() {
  now = new Date();
  seconds = (Date.parse(now) - Date.parse(event)) / 1000;

  val = (( {metal_perhour} / 3600) * seconds) + {metalh};
  if( val >= {metal_mmax} ) val = {metalh};
  document.getElementById('metal').innerHTML = number_format( val ,0);

  val = ( {crystal_perhour} / 3600) * seconds + {crystalh};
  if( val >= {crystal_mmax} ) val = {crystalh};
  document.getElementById('crystal').innerHTML = number_format( val ,0);

  val = ( {deuterium_perhour} / 3600) * seconds + {deuteriumh};
  if( val >= {deuterium_mmax} ) val = {deuteriumh};
  document.getElementById('deut').innerHTML = number_format( val ,0);


  ID=window.setTimeout('update();',1000);
}

function number_format(number,laenge) {
  number = Math.round( number * Math.pow(10, laenge) ) / Math.pow(10, laenge);
  str_number = number+'';
  arr_int = str_number.split('.');
  if(!arr_int[0]) arr_int[0] = '0';
  if(!arr_int[1]) arr_int[1] = '';
  if(arr_int[1].length < laenge){
        nachkomma = arr_int[1];
        for(i=arr_int[1].length+1; i <= laenge; i++){  nachkomma += '0';  }
        arr_int[1] = nachkomma;
  }
  if(arr_int[0].length > 3){
        Begriff = arr_int[0];
        arr_int[0] = '';
        for(j = 3; j < Begriff.length; j+=3){
          Extrakt = Begriff.slice(Begriff.length - j, Begriff.length - j + 3);
          arr_int[0] = '.' + Extrakt +  arr_int[0] + '';
        }
        str_first = Begriff.substr(0, (Begriff.length % 3 == 0)?3:(Begriff.length % 3));
        arr_int[0] = str_first + arr_int[0];
  }
  return arr_int[0]+''+arr_int[1];
}
// --></script>