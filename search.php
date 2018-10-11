<link rel="stylesheet" href="jquery-ui/themes/base/jquery.ui.all.css">
<?php
   include ('dbadapter.php');
   session_start();

   $adapter = new dbadapter();
   $sessionid=0;
   if (isset ($_COOKIE["id"]))
   {
       $sessionid = $_COOKIE["id"];
   }else
   {
       $gradeid = $_GET["grades"];
       $sessionid =$adapter->createsession ($gradeid);

       $_COOKIE["id"] = $sessionid;
   }


   if ($_GET) {
   	$gradeid =  $_GET["grades"];
   	if (isset($_GET["GO"]))
   	{
       $GO = urlencode($_GET["GO"]);

   	$searchquery = $_GET["GO"];
   	$issuggestion = $_GET["suggestion"];
   	$trigger=$_GET["trigger"];

    $URL = 'https://api.cognitive.microsoft.com/bing/v7.0/search?q='. //'https://api.cognitive.microsoft.com/bing/v7.0/news/search?q=' .
   	$GO .
   	'&count=10&offset=0&mkt=en-us&safeSearch=Strict';
   	$subs_key = ' ';

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $URL);
       curl_setopt($ch, CURLOPT_HTTPGET, 1);
       curl_setopt($ch, CURLOPT_HTTPHEADER,
   	   array('Ocp-Apim-Subscription-Key: '.$subs_key, "Content-Type: application/json"));
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
       curl_setopt($ch, CURLOPT_TIMEOUT, 10);
       $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // this results 0 every time
       $response = curl_exec($ch);
       if ($response === false) $response = curl_error($ch);
       curl_close($ch);

       $response = json_decode($response);


   	$searchid  = $adapter->storesearch ($searchquery,$sessionid,$issuggestion, $trigger);
   	}

   }


   ?>
<html>
   <head>
      <style type="text/css">
         body
         {
         //background: #F2F2F2;
         //background-image: url("img4.jpg");
         font-size : 15px;
         font-family: arial,sans-serif;
         }
         .title
         {
         text-transform: capitalize;
         font-size : 18px;
         font-weight: bold;
         color: #b3b3ff;
         width:700px;
         max-width: 90ch;
         overflow:hidden;
         text-overflow:ellipsis;
         white-space: nowrap;
         left: 155px;
         position: relative
         }
         div.relative {
         position: relative;
         left: 155px;
         margin:auto;
         float:left;
         }
         link {
         display: inline-block;
         text-decoration:none
         }
         a:after {
         content: "";
         display: block;
         width: 0;
         border-bottom: 1px solid;
         margin: 0 auto;
         transition:all 0s linear 0s;
         }
         a:hover:after {
         width: 100%;
         }
         .news
         {
         margin-left : 10px;
         float:left;
         left:155px;
         text-transform: lowercase;
         text-align: justify;
         text-justify: inter-word;
         position: relative;
         width:700px;
         }
         div.relative:first-letter {
         text-transform: uppercase;
         }
      </style>
   </head>
   <body>
      <a href="index.php" style="text-decoration: none"><button>Home Page</button></a>
      <form action="" method="GET">
         <center>
            <img src="search.jpg" alt="image" width="350" height="200">
            <br>
            <input id="searchinput" type="text" placeholder="Enter Search or Type URL..." style="font-size:20px;font-family: arial,sans-serif;height:30px;width:750px;" value ='<?php echo (isset($searchquery)?$searchquery:"")?>'  name="GO">
            <input hidden="hidden" type="text" value="false" name="suggestion" id="suggestion" />
            <input hidden=hidden" type="text" value="none" name="trigger" id="trigger"/>
            <input hidden="hidden" type="text" value ='<?php if(isset($gradeid))echo $gradeid?>'  name="grades">
            <input type="submit" style="height:30px;width:40px; " value="GO">
         </center>
         <br/>
         <br/>
         <br/>
         <br/>
         <br/>
         <br/>
      </form>
      <?PHP
         if (isset($_GET["GO"])){
          echo "<div class='news'>";
         	$position=1;

             foreach ($response->webPages->value as $result) {

                 $title = $result->name;
                 $url = $result->url;
                 $desc = $result->snippet;


                 echo "<div class='title'><a class='link a' data-position='$position'   STYLE=\"text-decoration: none; color:#6666ff;\" target= '_blank' href='$url'>$title</a></div>";
                 echo "<div class='relative'><p>$desc</p>" . "<br><br>". "</div>";


                 echo "<br>";
                 echo "<br>";
         		$position++;
             }
         	echo "</div>";
         	}
         ?>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script>
         $(function (){
         	$(".link").click (function (){
         	console.log ("clicked");
         		var link =$(this).attr('href');
         		var position = $(this).attr('data-position');
         		var sessionid = '<?php if (isset($sessionid)) echo $sessionid ?>';
         		var searchid = '<?php if (isset($searchid)) echo $searchid ?>';
         		var datal ="sessionid="+sessionid+"&url="+link+"&searchid="+searchid+"&position="+position;
         		$.ajax({
         			url : 'postlink.php',
         			data : datal,
         			type : 'POST',


         			success  : function (data){
         				console.log (data);
         				console.log (datal);
         			}
         		});
         	});
         	});
      </script>
      <script src="jquery-ui/jquery-1.7.1.js"></script>
      <script src="jquery-ui/ui/jquery.ui.core.js"></script>
      <script src="jquery-ui/ui/jquery.ui.widget.js"></script>
      <script src="jquery-ui/ui/jquery.ui.position.js"></script>
      <script src="jquery-ui/ui/jquery.ui.autocomplete.js"></script>
      <script type="application/javascript">
         $(function () {

             $("#searchinput").autocomplete({
         select: function (event,ui){
         var trigger=$("#searchinput").val(); //trigger is the search input value. That was how i captured it
         	$('#suggestion').val("true");
         	$('#trigger').val(trigger);
         },
                 source: function (request, response) {

                     $.ajax({
                         url:  "http://api.bing.com/osjson.aspx?Query=" + encodeURIComponent(request.term) + "&JsonType=callback&JsonCallback=?",
                         dataType: "jsonp",
                       //  data: {
                       //   "reqterm": (request.term)
                        //  "JsonType": "callback",
                        //  "JsonCallback" : "?"
                       //   },


                          success: function (data) {
                             console.log(data);
                             var suggestions = [];
                             $.each(data[1], function (i, val) {


                                 suggestions.push(val);
                             });
                             response(suggestions.slice(0, 5));

                         }
                     });
                 }
             });
         });
      </script>
   </body>
</html>