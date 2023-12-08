<?php



namespace Fakell\Bing\Constant;



interface Defaults {


    const OPTIONS_SET = [
        "nlu_direct_response_filter",
        "deepleo",
        "disable_emoji_spoken_text",
        "responsible_ai_policy_235",
        "enablemm",
        "dv3sugg",
        "iyxapbing",
        "iycapbing",
        "galileo",
        "saharagenconv5",
        "eredirecturl"
    ];

    const CONVERSATION_HISTORY_OPTIONS = [
        "autosave",
        "savemem",
        "uprofupd",
        "uprofgen"
    ];
    
    const ALLOWED_MESSAGE_TYPES = [
        "ActionRequest",
        "Chat",
        "ConfirmationCard",
        "Context",
        "InternalSearchQuery",
        "InternalSearchResult",
        "Disengaged",
        "InternalLoaderMessage",
        "InvokeAction",
        "Progress",
        "RenderCardRequest",
        "RenderContentRequest",
        "AdsQuery",
        "SemanticSerp",
        "GenerateContentQuery",
        "SearchQuery"
    ];

    const DELIMITER = "";
    const LOCATION = [
        [
            "SourceType" => 1,
            "RegionType" => 2,
            "Center" => [
                "Latitude" => -18.90880012512207,
                "Longitude" => 47.53459930419922
            ],
            "Radius" => 24902,
            "Name" => "Antananarivo, Analamanga",
            "Accuracy" => 24902,
            "FDConfidence" => 0,
            "CountryName" => "Madagascar",
            "CountryConfidence" => 9,
            "Admin1Name" => "Analamanga",
            "PopulatedPlaceName" => "Antananarivo",
            "PopulatedPlaceConfidence" => 0,
            "UtcOffset" => 3,
            "Dma" => 0
        ]
    ];
    const HEDEARS = [
        "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69",
        'accept'=> '*/*',
        'accept-language'=> 'en-US,en;q=0.9',
        'cache-control'=> 'max-age=0',
        'sec-ch-ua'=> '"Chromium";v="110", "Not A(Brand";v="24", "Microsoft Edge";v="110"',
        'sec-ch-ua-arch'=> '"x86"',
        'sec-ch-ua-bitness'=> '"64"',
        'sec-ch-ua-full-version'=> '"110.0.1587.69"',
        'sec-ch-ua-full-version-list'=> '"Chromium";v="110.0.5481.192", "Not A(Brand";v="24.0.0.0", "Microsoft Edge";v="110.0.1587.69"',
        'sec-ch-ua-mobile'=> '?0',
        'sec-ch-ua-model'=> '""',
        'sec-ch-ua-platform'=> '"Windows"',
        'sec-ch-ua-platform-version'=> '"15.0.0"',
        'sec-fetch-dest'=> 'document',
        'sec-fetch-mode'=> 'navigate',
        'sec-fetch-site'=> 'none',
        'sec-fetch-user'=> '?1',
        'upgrade-insecure-requests'=> '1'
    ];
}