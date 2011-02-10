<?php
$categories=array(
"Allgemein",
"Amarok",
"bash",
"basteln",
"gewinnspiele",
"Hardware",
"IPod",
"linux",
"mysql",
"perl",
"php",
"programmieren",
"python",
"ruby",
"schlaue tipps für dein Leben",
"sql",
"surfen",
"Thinkpad",
"Uncategorized",
"webkrams",
"wordpress",
"xbox 360",
"XML",
"zocken"
);

$content1='Ich besitze zwar einen Fernseher aber kein Rundfunkempfangsger&auml;t. Der Fernseher dient  nur dem Zweck ab und an ein wenig Konsole zu spielen oder mit dem WDTV einen Film zu schauen. Ich schaue mir einmal am Tag die Tage&szlig;chau an und w&uuml;rde das auch gerne mal auf meinem eigenen Fernseher ansehen und nicht vor dem Monitor oder bei Bekannten.

	Dank der modifizierten Firmware von b-rad kann man ja einiges mit dem WDTV anstellen  und es gibt auch einige Livesender im Internet. Beides zu verbinden hat durchaus seinen Reiz. Leider ist es von den diesen Anbietern ja meist nur angedacht den Stream im Browser mit Flash zu schauen. Bei dem WDTV brauche ich gar nicht an Flash zu denken. Also  mu&szlig; ich wohl oder &uuml;bel an den eigentlichen Stream und etwas f&uuml;r die WDTV basteln.
<p>
	Ab und an hat man das Gl&uuml;ck und kommt an eine mms:// Adre&szlig;e aber  oft ist das leider nicht der Fall. Den Stream von Phoenix kann man sich unter der
<p>
	mms://live.msmedia.zdf.newmedia.nacamar.net/zdf/phoenix_vh.wmv
<p>
	konsumieren wenn Phoenix Lust hat den Stream einzuschalten. Ohne solche Urls mu&szlig; man wohl oder &uuml;bel einen Blick in den Seitenquelltext (Bitte niemals nie mit Source Code oder Code bezeichnen) der Html Seite schauen. Sehr n&uuml;tzlich ist dabei Firefox und die Adblock Plus Erweiterung.
<p>
	Dieser Artikel ist prim&auml;r f&uuml;r mein verge&szlig;liches Hirn gedacht. Drum r&uuml;cke ich hier eine sehr grobe Erkl&auml;rung wie ich mir das mit dem Streaming vorstelle ein.
<p>
	Prinzipiell kommt beim Streamingkonsum neben dem Browser noch ein 2. Client ins Spiel. Dabei handelt es sich leider zu oft um den Flash Player. In Html erkennt man ihn an der Endung .swf (Shockwave Flash). Dieser Client verbindet sich mit einem Server  der das Video zum Client bringt.
<p>
	Wir haben also einen Client im Client. Von daher ist es nicht nur logisch, sondern auch gerecht, da&szlig; man die Adre&szlig;e des Streaming Servers herausfinden kann.   Wenn der Streamingserver eine andere Adre&szlig;e als der Webserver hat welcher die Seite mit dem Flashplayer hostet ist das meiner/unserer/Eurer Sache mehr als dienlich.
<p>
	An manche Streams kommt man sehr einfach. Hier ist Adblock+ sehr hilfreich. Man klicke auf das rote Icon und dann auf Blockierbare Elemente anzeigen. Nun ordnet man die Elemente der ge&ouml;ffneten Seite nach der Adre&szlig;e und schaut sich einfach mal an was da so referenziert wird:  
<p>
	In der Liste sieht man sehr sch&ouml;n, da&szlig; Elemente von 3 verschiedenen Seiten hier gelistet sind. Auf einer dieser Seiten befinden wir uns gerade. Nun schlie&szlig;en wir Google als Quelle aus und nat&uuml;rlich die xml Datei. Die 3. Url &uuml;bergeben wir einfach mal dem wahren Omnivoren unter den Mediaplayern: mplayer. Der kommt auch direkt damit klar.
<p>
	Gl&uuml;ck gehabt:).
<p>
	Nun haben wir schon 2 Quellen aus denen wir recht einfach Livestreams abgreifen k&ouml;nnen und das Thema ist zur 2/3 ersch&ouml;pft - jedenfalls was mein aktuelles Wi&szlig;en betrifft. 
<p>
	Adobe hat sich extra ein propriet&auml;res Netzwerkprotokoll ausgedacht um diese Flashplayer zu bedienen. Das Ganze h&ouml;rt auf den Namen RTMP.
<p>
	Ich m&ouml;chte kein Beispiel aus dem Leben zeigen, da ich keine Ahnung habe, ob ich mich da irgendwie strafbar mache.
<p>
	Bevor man loslegen kann wird das Programm rtmpdump ben&ouml;tigt. Dieses Tool scheint auch aus der Feder der Omnivorensch&ouml;pfer zu stammen. Das Teil ist recht einfach gebaut, einzig bei Debian f&uuml;r ARM Plattformen (dazu sp&auml;ter mehr) mu&szlig;te ich explizit die libc6-dev installieren.Das Paket gcc kommt ohne aus. Fachlich korrekt aber irgendwie sinnfrei. 5 Minuten meines Lebens wieder mal mit nichts verschwendet. Wie das auf meinem PC war kann ich nicht mehr genau bestimmen. Doch zur&uuml;ck zu RTMP. Ich wollte einen Stream der vom JW Player abgespielt wird.
<p>
	Die Bedienung von rtmdump wirkt auf den ersten Blick reichlich schr&auml;g - wie alles was mit Multimedia auf der Konsole zu tun hat - ist jedoch recht eing&auml;ngig wenn man die Readme sorgf&auml;ltig liest.
<p>
	Um dem JW Player den Stream abzuringen werden einige Dinge ben&ouml;tigt, die man au&szlig;chlie&szlig;lich im Markup findet:
<ul>
<li>	die swf Url: http://player.longtailvideo.com/player.swf</li>
<li>	die Url des RTMP Streams - schaut immer so aus rtmp://\"Dein Stream\"</li>
<li>	ein File(file=\") -  immer in der N&auml;he von rtmp und swf zu finden</li>
<li>	Der JW Player m&ouml;chte noch einen recht d&auml;mlichen Handshake bevor der Spa&szlig; losgeht. Der sieht so aus:</li>
</ul>
	Zuerst wird die swf Datei heruntergeladen, deren Gr&ouml;&szlig;e bestimmt und der sha-256 digest des Files bestimmt. Beide Werte m&uuml;&szlig;en wir rtmpdump &uuml;bergeben.  Ohne diese Argumente gibt es auch keinen Stream  .

	Zum Testen bietet es sich an ein Script anzulegen um bequem mit dem Unfug spielen zu k&ouml;nnen. Bei mir sieht das nun so aus:

	#!/bin/bash
	name=\'arte\'
	###SWF url
	swfurl=\'http://player.longtailvideo.com/player.swf\'
	###RTMP
	urlrtmpuri=\'rtmp://URL/\'
	##file
	file=\"
	wget -O /tmp/player.swf $flvurl  &>/dev/null
	sum=$(sha256sum /tmp/player.swf |cut -d \" \" -f 1)
	size=$(ls -l /tmp/player.swf | cut -d \" \" -f 5)
	output=$name.flvrtmpdump -V -r $rtmpuri -y $file -s $swfurl -w $sum -x $size -o $output
	Die Option -V steigert wie immer die Gespr&auml;chigkeit, den Rest kann man der Readme entnehmen. Nun &ouml;ffnet man einfach den Output von rtmpdump mit mplayer  - in diesem kleinen  Beispiel arte.flv und man sieht hoffentlich einen sch&ouml;nen Stream.

	Auf der Projektseite sind ein paar Programme gelistet, die auf rtmpdump aufbauen, doch empfinde ich es immer wieder als nette Erfahrung mir solche Dinge einmal genauer anzuschauen.

	Soviel zu meinen Erfahrungen mit Livestreams und rtmpdump. Dieses Intermezzo war recht kurz weil ich noch nicht wirklich viel Ahung von der Geschichte habe. Zum Spa&szlig; habe ich mir das Ganze auch mal mit Wireshark angesehen und dabei and&auml;chtig &uuml;ber die Entwickler von rtmpdump reflektiert. &uuml;ber weitere Infos zudem Thema w&uuml;rde ich mich nat&uuml;rlich sehr freuen.

	Im n&auml;chsten Schritt mu&szlig; nat&uuml;rlich Bild und Ton auf das WDTV. Ein rudiment&auml;res UMSP Skript habe ich mal erstellt aber noch nichts wirklch Vorzeigbares. Momentan plane ich das Encodieren und Dumpen auf meinem neuen NAS zu erledigen an dem sich dann mehrere Clients bedienen k&ouml;nnen. Das spart nicht nur Bandbreite im Flaschenhals DSL Anschlu&szlig; falls mehere Clients darauf zugreifen, sondern reduziert auch grausame WDTV Friemeleien auf ein Minimum.

	Nun bleibt mir nur noch zu fragen wie Ihr Streams konsumiert. Schaut Ihr im Browser? oder habt Ihr gar ein sch&ouml;nes Skript um Flash zu umgehen?
';


$recent="
<h1>#Letzte Artikel</h1>
<ul>
<li>Rtmpdump #1</li>
<li>WDTV – Moviesheets</li>
<li>Matroska Headercompression vs. WDTV</li>
<li>Firewall mit reverse ssh Tunnel perforieren</li>
<li>Bequemer Bashskripte zusammenfriemeln</li>
</ul>
";
$archiv="
<h1>#Archiv</h1>
<ul>
<li>Januar 2011</li>
<li>Dezember 2010</li>
<li>September 2010</li>
<li>August 2010</li>
<li>Juli 2010</li>
<li>Juni 2010</li>
<li>Mai 2010</li>
<li>April 2010</li>
<li>März 2010</li>
<li>Februar 2010</li>
<li>Dezember 2009</li>
<li>November 2009</li>
<li>September 2009</li>
<li>August 2009</li>
<li>Juli 2009</li>
<li>Juni 2009</li>
<li>Mai 2009</li>
<li>April 2009</li>
<li>März 2009</li>
<li>Februar 2009</li>
<li>Januar 2009</li>
<li>Dezember 2008</li>
<li>November 2008</li>
<li>Oktober 2008</li>
<li>September 2008</li>
</ul>
";


$lorem="Sed tincidunt tortor vitae arcu. Donec aliquam. Pellentesque tempor imperdiet risus. Sed nonummy ullamcorper enim. Maecenas tempus tincidunt orci. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi euismod convallis lacus. Quisque feugiat ullamcorper neque. Sed nunc.
Nunc quam eros, gravida at, vestibulum at, eleifend ac, augue. Cras imperdiet eleifend felis. Curabitur faucibus. Praesent dictum. Nam metus lorem, dapibus nonummy, vehicula eu, laoreet vitae, diam. Quisque malesuada dapibus mauris. Duis nulla nulla, gravida quis, suscipit non, sodales in, lacus. Praesent vel elit euismod magna vehicula scelerisque. Praesent luctus nisi sed quam. Donec condimentum. Curabitur nulla ante, posuere aliquam, venenatis nec, porta a, est.
Integer a justo. Aenean at velit. Sed at odio. Fusce felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean sed nisi vel odio rhoncus feugiat. Ut libero leo, auctor eget, mattis sit amet, dapibus et, orci. Quisque rutrum dui et purus. Fusce porttitor sagittis mauris. Proin iaculis felis eget pede. Nunc vitae purus. Duis mi pede, rutrum eu, semper sed, ultricies nonummy, pede. Vestibulum molestie diam sit amet velit. Suspendisse elementum, nulla et dignissim malesuada, sapien lorem gravida orci, quis ullamcorper sem metus eget felis. Praesent tincidunt turpis et metus. Fusce ac tellus. Curabitur dui urna, euismod et, ornare et, nonummy et, ante. Vivamus sed pede. Sed lacus. Etiam suscipit urna in mi.
Mauris a dolor. Duis dui purus, adipiscing id, lacinia eget, porttitor quis, diam. Cras vel diam. Sed rhoncus luctus felis. Maecenas enim. Morbi quis dolor a justo aliquam condimentum. Morbi ac nulla pellentesque ante rhoncus rhoncus. Quisque velit erat, tempus accumsan, porttitor vel, malesuada sit amet, magna. Proin molestie tempus leo. Nullam non dolor ut augue pretium posuere. Morbi nunc nibh, luctus feugiat, imperdiet ac, imperdiet sed, augue.
Suspendisse venenatis diam congue augue. Etiam tempor, purus vitae pulvinar mollis, ligula augue tempus metus, at sagittis lectus tellus quis tellus. Nulla ornare. Nunc accumsan blandit magna. Fusce ut sem. Suspendisse sem. Vestibulum ante. Phasellus sollicitudin, lacus in facilisis dignissim, sapien dolor placerat libero, id rutrum lectus nibh a arcu. Ut eleifend, nisl eget venenatis venenatis, metus nunc adipiscing magna, non malesuada pede risus in nibh. Mauris at mauris sed metus faucibus pulvinar. Nunc malesuada. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos.";


$footer="in valid code we trust (*^_^*) miss monorom";
?>
