# assparser
ASS/SSA subtitle Parser

# How to use
```PHP
$ap = new ASSAparser();
$sub = $ap->parse(file_get_contents('[CASO&SumiSora][TARI_TARI][01][1280x720][x264_AAC][4705E115].sc.ass'));
foreach($sub->Events->Dialogue as $dlg) {
	echo $dlg->Start . '　' . $ap->plainText($dlg->Text) . '<br>';
}
```
