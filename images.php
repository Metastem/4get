<?php

/*
	Initialize random shit
*/
include "lib/frontend.php";
$frontend = new frontend();

[$scraper, $filters] = $frontend->getscraperfilters("images");

$get = $frontend->parsegetfilters($_GET, $filters);

$frontend->loadheader(
	$get,
	$filters,
	"images"
);

$payload = [
	"images" => "",
	"nextpage" => ""
];

try{
	$results = $scraper->image($get);
	
}catch(Exception $error){
	
	echo
		$frontend->drawerror(
			"Shit",
			'This scraper returned an error:' .
			'<div class="code">' . htmlspecialchars($error->getMessage()) . '</div>' .
			'Things you can try:' .
			'<ul>' . 
				'<li>Use a different scraper</li>' .
				'<li>Remove keywords that could cause errors</li>' .
				'<li>Use another 4get instance</li>' .
			'</ul><br>' .
			'If the error persists, please <a href="/about">contact the administrator</a>.'
		);
	die();
}

if(count($results["image"]) === 0){
	
	$payload["images"] =
		'<div class="infobox">' .
			"<h1>Nobody here but us chickens!</h1>" .
			'Have you tried:' .
			'<ul>' .
				'<li>Using a different scraper</li>' .
				'<li>Using fewer keywords</li>' .
				'<li>Defining broader filters (Is NSFW turned off?)</li>' .
			'</ul>' .
		'</div>';
}
	
foreach($results["image"] as $image){
	
	$domain = htmlspecialchars(parse_url($image["url"], PHP_URL_HOST));
	
	$c = count($image["source"]) - 1;
	
	if(
		preg_match(
			'/^data:/',
			$image["source"][$c]["url"]
		)
	){
		
		$src = htmlspecialchars($image["source"][$c]["url"]);
	}else{
		
		$src = "/proxy?i=" . urlencode($image["source"][$c]["url"]) . "&s=thumb";
	}
	
	$payload["images"] .=
		'<div class="image-wrapper" title="' . htmlspecialchars($image["title"]) .'" data-json="' . htmlspecialchars(json_encode($image["source"])) . '">' .
			'<div class="image">' .
				'<a href="' . htmlspecialchars($image["source"][0]["url"]) . '" rel="noreferrer nofollow" class="thumb">' .
					'<img src="' . $src . '" alt="thumbnail">' .
					'<div class="duration">' . $image["source"][0]["width"] . 'x' . $image["source"][0]["height"] . '</div>' .
				'</a>' .
				'<a href="' . htmlspecialchars($image["url"]) . '" rel="noreferrer nofollow">' .
					'<div class="title">' . htmlspecialchars($domain) . '</div>' .
					'<div class="description">' . $frontend->highlighttext($get["s"], $image["title"]) . '</div>' .
				'</a>' .
			'</div>' .
		'</div>';
}

if($results["npt"] !== null){
	
	$payload["nextpage"] =
		'<a href="' . $frontend->htmlnextpage($get, $results["npt"], "images") . '" class="nextpage img">Next page &gt;</a>';
}

echo $frontend->load("images.html", $payload);
