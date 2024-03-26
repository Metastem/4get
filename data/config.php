<?php
class config{
	// Welcome to the 4get configuration file
	// When updating your instance, please make sure this file isn't missing
	// any parameters.
	
	// 4get version. Please keep this updated
	const VERSION = 7;
	
	// Will be shown pretty much everywhere.
	const SERVER_NAME = "4get";
	
	// Will be shown in <meta> tag on home page
	const SERVER_SHORT_DESCRIPTION = "They live in our walls!";
	
	// Will be shown in server list ping (null for no description)
	const SERVER_LONG_DESCRIPTION = null;
	
	// Add your own themes in "static/themes". Set to "Dark" for default theme.
	// Eg. To use "static/themes/Cream.css", specify "Cream".
	const DEFAULT_THEME = "Dark";
	
	// Enable the API?
	const API_ENABLED = true;
	
	//
	// BOT PROTECTION
	//
	
	// 0 = disabled, 1 = ask for image captcha, @TODO: 2 = invite only (users needs a pass)
	// VERY useful against a targetted attack
	const BOT_PROTECTION = 0;
	
	// if BOT_PROTECTION is set to 1, specify the available datasets here
	// images should be named from 1.png to X.png, and be 100x100 in size
	// Eg. data/captcha/birds/1.png up to 2263.png
	const CAPTCHA_DATASET = [
		// example:
		// ["birds", 2263],
		// ["fumo_plushies", 1006],
		// ["minecraft", 848]
	];
	
	// If this regex expression matches on the user agent, it blocks the request
	// Not useful at all against a targetted attack
	const HEADER_REGEX = '/bot|wget|curl|python-requests|scrapy|go-http-client|ruby|yahoo|spider/i';
	
	// Block clients who present any of the following headers in their request (SPECIFY IN !!lowercase!!)
	// Eg: ["x-forwarded-for", "x-via", "forwarded-for", "via"];
	// Useful for blocking *some* proxies used for botting
	const FILTERED_HEADER_KEYS = [
		"x-forwarded-for",
		"x-cluster-client-ip",
		"x-client-ip",
		"x-real-ip",
		"client-ip",
		"real-ip",
		"forwarded-for",
		"forwarded-for-ip",
		"forwarded",
		"proxy-connection",
		"remote-addr",
		"via",
	];
	
	// @TODO: Portscan the user for open proxies before allowing a connection, block user if any are found
	// Requires the nmap package
	const NMAP_PROXY_CHECK = false;
	
	// @TODO: Make IP blacklist public under /api/v1/blacklist endpoint ?
	const PUBLIC_IP_BLACKLIST = true;
	
	// Maximal number of searches per captcha key/pass issued. Counter gets
	// reset on every APCU cache clear (should happen once a day).
	// Only useful when BOT_PROTECTION is NOT set to 0
	const MAX_SEARCHES = 100;
	
	// List of domains that point to your servers. Include your tor/i2p
	// addresses here! Must be a valid URL. Won't affect links placed on
	// the homepage.
	const ALT_ADDRESSES = [
		//"https://4get.alt-tld",
		//"http://4getwebfrq5zr4sxugk6htxvawqehxtdgjrbcn2oslllcol2vepa23yd.onion"
	];
	
	// Known 4get instances. MUST use the https protocol if your instance uses
	// it. Is used to generate a distributed list of instances.
	// To appear in the list of an instance, contact the host and if everyone added
	// eachother your serber should appear everywhere.
	const INSTANCES = [
		"https://4get.ca",
		"https://4get.zzls.xyz",
		"https://4getus.zzls.xyz",
		"https://4get.silly.computer",
		"https://4get.konakona.moe",
		"https://4get.lvkaszus.pl",
		"https://4g.ggtyler.dev",
		"https://4get.perennialte.ch",
		"https://4get.sijh.net",
		"https://4get.hbubli.cc",
		"https://4get.plunked.party",
		"https://4get.seitan-ayoub.lol",
		"https://4get.etenie.pl",
		"https://4get.lunar.icu",
		"https://4get.dcs0.hu",
		"https://4get.kizuki.lol",
		"https://4get.psily.garden",
		"https://search.milivojevic.in.rs",
		"https://4get.snine.nl",
		"https://4get.datura.network",
		"https://4get.neco.lol"
	];
	
	// Default user agent to use for scraper requests. Sometimes ignored to get specific webpages
	// Changing this might break things.
	const USER_AGENT = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:124.0) Gecko/20100101 Firefox/124.0";
	
	// Proxy pool assignments for each scraper
	// false = Use server's raw IP
	// string = will load a proxy list from data/proxies
	// Eg. "onion" will load data/proxies/onion.txt
	const PROXY_DDG = false; // duckduckgo
	const PROXY_BRAVE = false;
	const PROXY_FB = false; // facebook
	const PROXY_GOOGLE = false;
	const PROXY_MARGINALIA = false;
	const PROXY_MOJEEK = false;
	const PROXY_SC = false; // soundcloud
	const PROXY_SPOTIFY = false;
	const PROXY_WIBY = false;
	const PROXY_CURLIE = false;
	const PROXY_YT = false; // youtube
	const PROXY_YEP = false;
	const PROXY_PINTEREST = false;
	const PROXY_SEZNAM = false;
	const PROXY_NAVER = false;
	const PROXY_CROWDVIEW = false;
	const PROXY_MWMBL = false;
	const PROXY_FTM = false; // findthatmeme
	const PROXY_IMGUR = false;
	const PROXY_YANDEX_W = false; // yandex web
	const PROXY_YANDEX_I = false; // yandex images
	const PROXY_YANDEX_V = false; // yandex videos
	
	//
	// Scraper-specific parameters
	//
	
	// SOUNDCLOUD
	// Get these parameters by making a search on soundcloud with network
	// tab open, then filter URLs using "search?q=". (No need to login)
	const SC_USER_ID = "447501-577662-794348-352629";
	const SC_CLIENT_TOKEN = "VNc62l3wxDWS0Ol62j5UYNc1gsZ3UXPv";
	
	// MARGINALIA
	// Get an API key by contacting the Marginalia.nu maintainer. The "public" key
	// works but is almost always rate-limited.
	const MARGINALIA_API_KEY = "public";
}
