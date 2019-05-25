<?php
// =================================================================
// ========================= Starten på sida ===========================
// =================================================================
// klasse som gjer den meste av den avanserte jobben (generisk)..
require_once("supersimplemediabrowser.php");
// klasse som er laga for denne løysningen
require_once("function.php");
// i denne ligger innstillingane som du må justere på.
require_once("settings.php");

// Bygg ei indekseringsfil i kvar hovudmappe
// superSimpleMediaBrowser har tre parametere
// 1 = Adressen til sida i web format e.g http://localhost/, eller https://www.arne.no/
// 2 = Bestemmer kor på serveren bildebasen benynner, normalt er ""
// 3 = FallbackUrl, dersom brukeren legg inn ei adresse som superSimpleMediaBrowser ikkje skjønner, kva mappe skal me då gå til.
//  3.1 = Du kan bytte ut 2019 med date("Y") for at årstallet skal bli henta frå serveren, vil då ve oppdatert heile tida.
$cls = new superSimpleMediaBrowser($BaseUrl , "",$FallbackFolder, null);
$Files = $cls->parseMediaDataFile();
$Folder = $cls->getFolders(0);

if($Files==null AND $Folder==null)
{
	  // Dersom ingen bilder er funnet, så kaller vi på sida 404.html
	  // den viser då ein feilmelding, den kan jo pussast opp litt.
	  header("HTTP/1.0 404 Not Found");
	  exit;
}

// Bilder er funnet. Vi fortsett å viser resten av sida.
// Dette er menyen som viser årstalla
$HTML_AARSTALL = buildAarstall($BaseUrl, $BilderFraAaar, $Folder);
// Denne bygger månedskategoriene for eit aktuelle år.
$HTML_KATEGORIER = buildMaanedsKategorier($BaseUrl, $Kategorier, $Folder);

// Dette er html koden som viser alle bildene for det aktuelle året.
$HTML_BILDER = hentBilder($Files);

// =================================================================
// ======================== Under her starter html  sida ==================
// =================================================================
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Arne, Bilder</title>
<meta name="Arne.no, Arne Ødegård" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="description" content="Arne Ødegård, familiebilder: Fra 1999 og før, fram til i dag, familiebilder,bilder,html5-org-av-12000 bilder,bilde-organisering-på-nett.">
<meta name="description" content="Arne Ødegård, family photos: more than 12000 photos online, organize family photos.">
<!-- Link Swiper's CSS -->
<link rel="stylesheet" href="https://www.arne.no/aJS/swiper.min.css">
<script src="https://www.arne.no/aJS/swiper.min.js"></script>
<style>


  #arsikon2019{

	position: static;

    top: 6px;

    left: 5px;

	z-index: 5000;

}

  

  

  

  

#arsikon2019{

	position: static;

    top: 6px;

    left: 40px;

	z-index: 5000;

}

  

#arsikon2017{	

	position: static;

    top: 6px;

    left: 80px;

	z-index: 5000;

}

	

#arsikon2016{

	position: static;

    top: 6px;

    left: 120px;

	z-index: 5000;

}

	 

#arsikon2015{

	position: static;

    top: 6px;

    left: 160px;

	z-index: 5000;

}

	 

#arsikon2014{

	position: static;

    top: 6px;

    left: 200px;

	z-index: 5000;

}

#arsikon2013{

	position: static;

    top: 6px;

    left: 240px;

	z-index: 5000;

}

#arsikon2012{

	position: static;

    top: 6px;

    left: 280px;

	z-index: 5000;

}



#arsikon2011{

	position: static;

    top: 6px;

    left: 320px;

	z-index: 5000;

}



#arsikon2010{

	position: static;

    top: 6px;

    left: 360px;

	z-index: 5000;

}



#arsikon2009{

	position: static;

    top: 6px;

    left: 400px;

	z-index: 5000;

}



#arsikon2008{

	position: static;

    top: 6px;

    left: 440px;

	z-index: 5000;

}



#arsikon2007{

	position: static;

    top: 6px;

    left: 480px;

	z-index: 5000;

}



#arsikon2006{

	position: static;

    top: 6px;

    left: 520px;

	z-index: 5000;

}



#arsikon2005{

	position: static;

    top: 6px;

    left: 560px;

	z-index: 5000;

}



#arsikon2004{

	position: static;

    top: 6px;

    left: 600px;

	z-index: 5000;

}



#arsikon2003{

	position: static;

    top: 6px;

    left: 640px;

	z-index: 5000;

}



#arsikon2002{

	position: static;

    top: 6px;

    left: 6800px;

	z-index: 5000;

}



#arsikon2001{

	position: static;

    top: 6px;

    left: 720px;

	z-index: 5000;

}



#arsikon2000{

	position: static;

    top: 6px;

    left: 760px;

	z-index: 5000;

}



#arsikon1999{

	position: static;

    top: 6px;

    left: 800px;

	z-index: 5000;

}

 

#bloggikon{

	position: static;

	top: 6px;

	left: 840px;

    z-index: 1000;

}	

  #APIikon{

	position: fixed;

	top: 2px;

	right: 10px;

    z-index: 1000;

}	

html, body {

      position: relative;

      height: 100%;

    }



body {

      background: #fff;

      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;

      font-size: 14px;

      color:#000;

      margin: 0;

      padding: 0;

    }

   

.swiper-slide {

      text-align: center;

      font-size: 18px;

      background: #fff;



    }

	

.swiper-container {

	 position: fixed;

      width: 100%;

      height: 100%;

      margin-left: 0px;

	  margin-top:6px;

      margin-right: auto;

    }

	

.swiper-slide img {

      margin-left: 1px;

      margin-right: 1px;

     }

 

  </style>

</head>

<body>





<a href="http://www.idangero.us/" target="_blank"><img src="https://www.arne.no/AarsIkon/API.jpg" id=APIikon></a>









<?php
echo($HTML_AARSTALL);
?>


<a href="https://www.arne.no/TechBlog.php" target="_self"><img src="https://www.arne.no/AarsIkon/Blogg.jpg" id=bloggikon></a> 






<img src="https://www.arne.no/AarsIkon/Blank.jpg" id=arsikon2009></a> 

<img src="https://www.arne.no/AarsIkon/Blank.jpg" id=arsikon2008></a> 

<img src="https://www.arne.no/AarsIkon/Blank.jpg" id=arsikon2007></a> 

<img src="https://www.arne.no/AarsIkon/Blank.jpg" id=arsikon2006></a> 
<br><br>


<?php
echo($HTML_KATEGORIER );
?>




<!-- Swiper -->

  <div class="swiper-container">

    <div class="swiper-wrapper">


		<?php
		echo($HTML_BILDER);
		?>



	</div>

	</div>

	

  



    <!-- Add Pagination -->

    <div class="swiper-pagination swiper-pagination-blue"></div>

    <!-- Navigation -->

    <div class="swiper-button-next swiper-button-blue"></div>

    <div class="swiper-button-prev swiper-button-blue"></div>

	



	

	

	

  <!-- Initialize Swiper -->

  <script>

    var swiper = new Swiper('.swiper-container', {

	  preloadImages: false,

	  lazy: true,

	  lazy: {

          loadPrevNext: true,

        },

      

      pagination: {

        el: '.swiper-pagination',

        color: 'black',

      },

      navigation: {

        nextEl: '.swiper-button-next',

        prevEl: '.swiper-button-prev',

      },

      spaceBetween: 30,

      centeredSlides: true,

      mousewheel: true,

      keyboard: {

        enabled: true,

      },

      

	pagination: {

        el: '.swiper-pagination',

	   type: 'fraction',

	   color: 'black',

        

      },



          });

 

  

  </script>

 



</body>

</html>
