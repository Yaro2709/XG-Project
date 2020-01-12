	<?php
	$msg=preg_replace("#\[a=(ft|https?://)(.+)\](.+)\[/a\]#isU", "<a href=\"$1$2\" target=\"_blank\">$3</a>", $msg);
	$msg=preg_replace("#\[b\](.+)\[/b\]#isU","<b>$1</b>",$msg);
	$msg=preg_replace("#\[i\](.+)\[/i\]#isU","<i>$1</i>",$msg);
	$msg=preg_replace("#\[u\](.+)\[/u\]#isU","<u>$1</u>",$msg);
	$msg=preg_replace("#\[c=(white|Blue|yellow|green|pink|red|orange|lime|BlueViolet|cyan)\](.+)\[/c\]#isU","<font color=\"$1\">$2</font>",$msg);

	// Les smileys avec leurs raccourcis
	$msg=preg_replace("#:agr:#isU","<img src=\"styles/images/smileys/aggressive.gif\" align=\"absmiddle\" title=\":agr:\" alt=\":agr:\">",$msg);
	$msg=preg_replace("#:angel:#isU","<img src=\"styles/images/smileys/angel.gif\" align=\"absmiddle\" title=\":angel:\" alt=\":angel:\">",$msg);
	$msg=preg_replace("#:bad:#isU","<img src=\"styles/images/smileys/bad.gif\" align=\"absmiddle\" title=\":bad:\" alt=\":bad:\">",$msg);
	$msg=preg_replace("#:blink:#isU","<img src=\"styles/images/smileys/blink.gif\" align=\"absmiddle\" title=\":blink:\" alt=\":blink:\">",$msg);
	$msg=preg_replace("#:blush:#isU","<img src=\"styles/images/smileys/blush.gif\" align=\"absmiddle\" title=\":blush:\" alt=\":blush:\">",$msg);
	$msg=preg_replace("#:bomb:#isU","<img src=\"styles/images/smileys/bomb.gif\" align=\"absmiddle\" title=\":bomb:\" alt=\":bomb:\">",$msg);
	$msg=preg_replace("#:clap:#isU","<img src=\"styles/images/smileys/clapping.gif\" align=\"absmiddle\" title=\":clap:\" alt=\":clap:\">",$msg);
	$msg=preg_replace("#:cool:#isU","<img src=\"styles/images/smileys/cool.gif\" align=\"absmiddle\" title=\":cool:\" alt=\":cool:\">",$msg);
	$msg=preg_replace("#:c:#isU","<img src=\"styles/images/smileys/cray.gif\" align=\"absmiddle\" title=\":c:\" alt=\":c:\">",$msg);
	$msg=preg_replace("#:crz:#isU","<img src=\"styles/images/smileys/crazy.gif\" align=\"absmiddle\" title=\":crz:\" alt=\":crz:\">",$msg);
	$msg=preg_replace("#:diablo:#isU","<img src=\"styles/images/smileys/diablo.gif\" align=\"absmiddle\" title=\":diablo:\" alt=\":diablo:\">",$msg);
	$msg=preg_replace("#:cool2:#isU","<img src=\"styles/images/smileys/dirol.gif\" align=\"absmiddle\" title=\":cool2:\" alt=\":cool2:\">",$msg);
	$msg=preg_replace("#:fool:#isU","<img src=\"styles/images/smileys/fool.gif\" align=\"absmiddle\" title=\":fool:\" alt=\":fool:\">",$msg);
	$msg=preg_replace("#:rose:#isU","<img src=\"styles/images/smileys/give_rose.gif\" align=\"absmiddle\" title=\":rose:\" alt=\":rose:\">",$msg);
	$msg=preg_replace("#:good:#isU","<img src=\"styles/images/smileys/good.gif\" align=\"absmiddle\" title=\":good:\" alt=\":good:\">",$msg);
	$msg=preg_replace("#:huh:#isU","<img src=\"styles/images/smileys/huh.gif\" align=\"absmiddle\" title=\":huh:\" alt=\":|\">",$msg);
	$msg=preg_replace("#:D:#isU","<img src=\"styles/images/smileys/lol.gif\" align=\"absmiddle\" title=\":D\" alt=\":D\">",$msg);
	$msg=preg_replace("#:/#isU","<img src=\"styles/images/smileys/mellow.gif\" align=\"absmiddle\" title=\":/\" alt=\":/\">",$msg);
 	$msg=preg_replace("#:yu#isU","<img src=\"styles/images/smileys/yu.gif\" align=\"absmiddle\" title=\":yu\" alt=\":yu\">",$msg);
	$msg=preg_replace("#:unknw:#isU","<img src=\"styles/images/smileys/unknw.gif\" align=\"absmiddle\" title=\":unknw:\" alt=\":unknw:\">",$msg);
 	$msg=preg_replace("#:sad#isU","<img src=\"styles/images/smileys/sad.gif\" align=\"absmiddle\" title=\":(\" alt=\":(\">",$msg);
	$msg=preg_replace("#:smile#isU","<img src=\"styles/images/smileys/smile.gif\" align=\"absmiddle\" title=\":)\" alt=\":)\">",$msg); 
	$msg=preg_replace("#:shok:#isU","<img src=\"styles/images/smileys/shok.gif\" align=\"absmiddle\" title=\":shok:\" alt=\":shok:\">",$msg);
	$msg=preg_replace("#:rofl#isU","<img src=\"styles/images/smileys/rofl.gif\" align=\"absmiddle\" title=\":rofl\" alt=\":rofl\">",$msg);
	$msg=preg_replace("#:eye#isU","<img src=\"styles/images/smileys/blackeye.gif\" align=\"absmiddle\" title=\":eye\" alt=\":eye\">",$msg);
 	$msg=preg_replace("#:p#isU","<img src=\"styles/images/smileys/tongue.gif\" align=\"absmiddle\" title=\":p\" alt=\":p\">",$msg);
 	$msg=preg_replace("#;\)#isU","<img src=\"styles/images/smileys/wink.gif\" align=\"absmiddle\" title=\";)\" alt=\";)\">",$msg); 
	$msg=preg_replace("#:yahoo:#isU","<img src=\"styles/images/smileys/yahoo.gif\" align=\"absmiddle\" title=\":yahoo:\" alt=\":yahoo:\">",$msg);
	$msg=preg_replace("#:tratata:#isU","<img src=\"styles/images/smileys/mill.gif\" align=\"absmiddle\" title=\":tratata:\" alt=\":tratata:\">",$msg);
	$msg=preg_replace("#:fr#isU","<img src=\"styles/images/smileys/friends.gif\" align=\"absmiddle\" title=\":fr\" alt=\":fr\">",$msg);
	$msg=preg_replace("#:dr#isU","<img src=\"styles/images/smileys/drinks.gif\" align=\"absmiddle\" title=\":dr\" alt=\":dr\">",$msg);
	$msg=preg_replace("#:tease:#isU","<img src=\"styles/images/smileys/tease.gif\" align=\"absmiddle\" title=\":tease:\" alt=\":tease:\">",$msg);  
	
	$msg=preg_replace("#:mail1:#isU","<img src=\"styles/images/smileys/mail1.gif\" align=\"absmiddle\" title=\":mail1:\" alt=\":mail1:\">",$msg);  
	$msg=preg_replace("#:beee:#isU","<img src=\"styles/images/smileys/beee.gif\" align=\"absmiddle\" title=\":beee:\" alt=\":beee:\">",$msg);  
	$msg=preg_replace("#:preved:#isU","<img src=\"styles/images/smileys/preved.gif\" align=\"absmiddle\" title=\":preved:\" alt=\":preved:\">",$msg);  
	$msg=preg_replace("#:posle:#isU","<img src=\"styles/images/smileys/posle.gif\" align=\"absmiddle\" title=\":posle:\" alt=\":posle:\">",$msg);  
	$msg=preg_replace("#:nono:#isU","<img src=\"styles/images/smileys/nono.gif\" align=\"absmiddle\" title=\":nono:\" alt=\":nono:\">",$msg);  
	$msg=preg_replace("#:scratch:#isU","<img src=\"styles/images/smileys/scratch.gif\" align=\"absmiddle\" title=\":scratch:\" alt=\":scratch:\">",$msg);
	
	$msg=preg_replace("#:bc:#isU","<img src=\"styles/images/smileys/bc.gif\" align=\"absmiddle\" title=\":bc:\" alt=\":bc:\">",$msg);
	$msg=preg_replace("#:be:#isU","<img src=\"styles/images/smileys/be.gif\" align=\"absmiddle\" title=\":be:\" alt=\":be:\">",$msg);
	$msg=preg_replace("#:bh:#isU","<img src=\"styles/images/smileys/bh.gif\" align=\"absmiddle\" title=\":bh:\" alt=\":bh:\">",$msg);
	$msg=preg_replace("#:bi:#isU","<img src=\"styles/images/smileys/bi.gif\" align=\"absmiddle\" title=\":bi:\" alt=\":bi:\">",$msg);	
	$msg=preg_replace("#:bh:#isU","<img src=\"styles/images/smileys/bh.gif\" align=\"absmiddle\" title=\":bh:\" alt=\":bh:\">",$msg);
	$msg=preg_replace("#:bk:#isU","<img src=\"styles/images/smileys/bk.gif\" align=\"absmiddle\" title=\":bk:\" alt=\":bk:\">",$msg);		
	$msg=preg_replace("#:bl:#isU","<img src=\"styles/images/smileys/bl.gif\" align=\"absmiddle\" title=\":bl:\" alt=\":bl:\">",$msg);	
	$msg=preg_replace("#:br:#isU","<img src=\"styles/images/smileys/br.gif\" align=\"absmiddle\" title=\":br:\" alt=\":br:\">",$msg);	
	$msg=preg_replace("#:bx:#isU","<img src=\"styles/images/smileys/bx.gif\" align=\"absmiddle\" title=\":bx:\" alt=\":bx:\">",$msg);		
	$msg=preg_replace("#:cc:#isU","<img src=\"styles/images/smileys/cc.gif\" align=\"absmiddle\" title=\":cc:\" alt=\":cc:\">",$msg);	
	$msg=preg_replace("#:cr:#isU","<img src=\"styles/images/smileys/cr.gif\" align=\"absmiddle\" title=\":cr:\" alt=\":cr:\">",$msg);		
	$msg=preg_replace("#:cg:#isU","<img src=\"styles/images/smileys/cg.gif\" align=\"absmiddle\" title=\":cg:\" alt=\":cg:\">",$msg);		
	$msg=preg_replace("#:ci:#isU","<img src=\"styles/images/smileys/ci.gif\" align=\"absmiddle\" title=\":ci:\" alt=\":ci:\">",$msg);	
	$msg=preg_replace("#:co:#isU","<img src=\"styles/images/smileys/co.gif\" align=\"absmiddle\" title=\":co:\" alt=\":co:\">",$msg);	
	
	
	
	
	
	
	
	?>