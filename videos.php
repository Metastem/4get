<?php

/*
	Initialize random shit
*/
include "lib/frontend.php";
$frontend = new frontend();

[$scraper, $filters] = $frontend->getscraperfilters("videos");

$get = $frontend->parsegetfilters($_GET, $filters);

$frontend->loadheader(
	$get,
	$filters,
	"videos"
);

$payload = [
	"class" => "",
	"right-left" => "",
	"right-right" => "",
	"left" => ""
];

try{
	$results = $scraper->video($get);
	
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

$categories = [
	"video" => "",
	"author" => "",
	"livestream" => "",
	"playlist" => "",
	"reel" => ""
];

/*
	Set the main container
*/
$main = null;

if(count($results["video"]) !== 0){
	
	$main = "video";
	
}elseif(count($results["playlist"]) !== 0){
	
	$main = "playlist";
	
}elseif(count($results["livestream"]) !== 0){
	
	$main = "livestream";
	
}elseif(count($results["author"]) !== 0){
	
	$main = "author";
	
}elseif(count($results["reel"]) !== 0){
	
	$main = "reel";
}else{
	
	// No results found!
	echo
		$frontend->drawerror(
			"Nobody here but us chickens!",
			'Have you tried:' .
				'<ul>' .
					'<li>Using a different scraper</li>' .
					'<li>Using fewer keywords</li>' .
					'<li>Defining broader filters (Is NSFW turned off?)</li>' .
				'</ul>' .
			'</div>'
		);
	die();
}

/*
	Generate list of videos
*/
foreach($categories as $name => $data){
	
	foreach($results[$name] as $item){
		
		$greentext = [];
		
		if(
			isset($item["date"]) &&
			$item["date"] !== null
		){
			
			$greentext[] = date("jS M y @ g:ia", $item["date"]);
		}
		
		if(
			isset($item["views"]) &&
			$item["views"] !== null
		){
			
			$views = number_format($item["views"]);
			
			if($name != "livestream"){
				
				$views .= " views";
			}else{
				
				$views .= " watching";
			}
			
			$greentext[] = $views;
		}
		
		if(
			isset($item["followers"]) &&
			$item["followers"] !== null
		){
			
			$greentext[] = number_format($item["followers"]) . " followers";
		}
		
		if(
			isset($item["author"]["name"]) &&
			$item["author"]["name"] !== null
		){
			
			$greentext[] = $item["author"]["name"];
		}
		
		$greentext = implode(" • ", $greentext);
		
		if(
			isset($item["duration"]) &&
			$item["duration"] !== null
		){
			
			$duration = $frontend->s_to_timestamp($item["duration"]);
		}else{
			
			$duration = null;
		}
		
		$tabindex = $name == $main ? true : false;
		
		$categories[$name] .= $frontend->drawtextresult($item, $greentext, $duration, $get["s"], $tabindex);
	}
}

$payload["left"] = $categories[$main];

// dont re-draw the category
unset($categories[$main]);

/*
	Populate right handside
*/

$i = 1;
foreach($categories as $name => $value){
	
	if($value == ""){
		
		continue;
	}
	
	if($i % 2 === 1){
		
		$write = "right-left";
	}else{
		
		$write = "right-right";
	}
	
	$payload[$write] .=
		'<div class="answer-wrapper">' .
		'<input id="answer' . $i . '" class="spoiler" type="checkbox">' .
		'<div class="answer">' .
			'<div class="answer-title">' .
				'<a class="answer-title" href="?s=' . urlencode($get["s"]);
	
	switch($name){
		
		case "playlist":
			$payload[$write] .=
				'&type=playlist"><h2>Playlists</h2></a>';
			break;
		
		case "livestream":
			$payload[$write] .=
				'&feature=live"><h2>Livestreams</h2></a>';
			break;
		
		case "author":
			$payload[$write] .=
				'&type=channel"><h2>Authors</h2></a>';
			break;
		
		case "reel":
			$payload[$write] .=
				'&duration=short"><h2>Reels</h2></a>';
			break;
	}
	
	$payload[$write] .=
			'</div>' .
			$categories[$name] .
		'</div>' .
		'<label class="spoiler-button" for="answer' . $i . '"></label></div>';
	
	$i++;
}

if($i !== 1){
	
	$payload["class"] = " has-answer";
}

if($results["npt"] !== null){
	
	$payload["left"] .=
		'<a href="' . $frontend->htmlnextpage($get, $results["npt"], "videos") . '" class="nextpage">Next page &gt;</a>';
}

echo $frontend->load("search.html", $payload);
