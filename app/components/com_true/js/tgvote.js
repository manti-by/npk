/***************************************************\
**   True Gallery - A Joomla! Gallery Component    **
**   Validated (C) 2008	     by PaLyCH		   **
**   Version    : 2.0                              **
**   Homepage   : http://www.palpalych.ru          **
**   License    : Copyright, don't distribute      **
**   Based on   : true 1.6 by Andrey Datso **
\***************************************************/

function tgVote(id,i,total,total_count){
	var lsXmlHttp;
	var div = document.getElementById('tgvote'+id);
	div.innerHTML='<img src="'+live_site+'/components/com_true/images/loading.gif" border="0" align="absmiddle" /> '+tgvote_lang['UPDATING'];
	try	{
		lsXmlHttp=new XMLHttpRequest();
	} catch (e) {
		try	{ lsXmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try { lsXmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				alert(tgvote_lang['ALERT_BROWSER']);
				return false;
			}
		}
	}
	lsXmlHttp.onreadystatechange=function() {
		var response;
		if(lsXmlHttp.readyState==4){
			setTimeout(function(){
				response = lsXmlHttp.responseText;
				if(response=='1') div.innerHTML=tgvote_lang['THANKS'];
				else div.innerHTML=tgvote_lang['ALREADY_VOTE'];
			},500);
			setTimeout(function(){
				if(response=='1'){
					var newtotal = total_count+1;
					div.innerHTML='('+tgvote_lang['VOTES']+' '+(newtotal)+')';
					var percentage = ((total + i)/(newtotal))*20;
					document.getElementById('rating'+id).style.width=percentage+'%';
				} else {
					div.innerHTML='('+tgvote_lang['VOTES']+' '+(total_count)+')';
				}
			},1000);
		}
	}
	lsXmlHttp.open("GET",live_site+"/components/com_true/sub_votepic.php?func=vote&user_rating="+i+"&id="+id,true);
	lsXmlHttp.send(null);
}