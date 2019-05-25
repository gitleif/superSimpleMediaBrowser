<?php
// denne bygger html koden som må brukast av swiperen
function hentBilder($Files)
{
	if($Files!=null) 		// Filer er funnet
	{
		$element2='<div class="swiper-slide">#LINK1#<img data-src="#FILNAVN#" class="swiper-lazy">#LINK2#<div class="swiper-lazy-preloader"></div></div>';
		foreach($Files as $entryName)
		{
			
			
			$tmpElement2 = str_replace("#FILNAVN#", $entryName['baseurl'] ,$element2);
			
			if(isset($entryName['Url']) && $entryName['Url']!=null)
			{
				$tmpElement2 = str_replace("#LINK1#", "<a href='" . $entryName['Url'] . "' target='_blank'>",$tmpElement2);
				$tmpElement2 = str_replace("#LINK2#", "</a>" ,$tmpElement2);				
			}
			else
			{
				$tmpElement2 = str_replace("#LINK1#", "",$tmpElement2);
				$tmpElement2 = str_replace("#LINK2#", "" ,$tmpElement2);
			}
			
			$dirArray[] =$tmpElement2;				
		}
		$Text = implode($dirArray);
		return(sanitize_output($Text));
	}
	return null;
}

// Liten funksjon for å gjera  html koden mindre slik at ting går litt fortare.
	function sanitize_output($buffer)
	{		
		preg_match_all('/\s+/', $buffer, $match);
		$buffer = (count($match['0']) != 0) ? preg_replace('/\s+/', ' ', $buffer) : $buffer;
		preg_match_all('~>\s+<~', $buffer, $match);
		$buffer = (count($match['0']) != 0) ? preg_replace('~>\s+<~', '><', $buffer) : $buffer;
		preg_match_all('/<!--(.*)-->/Uis', $buffer, $match);
		$buffer = (count($match['0']) != 0) ? preg_replace('/<!--(.*)-->/Uis', '', $buffer) : $buffer;
		return $buffer;
	}

// Funkjson for å bygge Årstall lista i toppen av siden
	function buildAarstall($baseUrl, $TilgjengeligeAar, $ValgtAar)
	{
		$txt = null;
		foreach($TilgjengeligeAar as $aar)
		{
			if($ValgtAar==$aar)
			{
				$bilde = "https://www.arne.no/AarsIkon/indikator/$aar.jpg";
			}
			else
			{
				$bilde ="https://www.arne.no/AarsIkon/$aar.jpg";
			}
			
			$streng = "<a href='" . $baseUrl . "$aar/' target='_self'><img src='$bilde' id='arsikon$aar'></a>";

			$txt = $txt . $streng;	
		}
		// returner variabelen txt som no inneheld heile htmlkoden for årstall.
		return($txt);
	}
	
	function buildMaanedsKategorier($baseUrl, $Alle, $ValgtAar)
	{
		if(isset($Alle[$ValgtAar]))
		{
			$txt_mal = '<a href="#BASEURL##AAR#/#MAANED#/" target="_self"><img src="https://www.arne.no/AarsIkon/#MAANED#.jpg" id="arsikon#AAR#"></a>';
			$txt_out = "";
			foreach($Alle[$ValgtAar] as $item)
			{
				
				$txt = str_replace("#BASEURL#", $baseUrl, $txt_mal);
				$txt = str_replace("#AAR#", $ValgtAar, $txt);
				$txt = str_replace("#MAANED#", $item, $txt);
				$txt_out = $txt_out . $txt . "\n";
			}
			return $txt_out;
		}
		return null;
	}
	
	   function fixFilepath($txt)
        {
            return(str_replace("//","/",$txt));
        }
	
?>