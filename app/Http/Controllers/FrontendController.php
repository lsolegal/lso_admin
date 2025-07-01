<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VedicAstroApi;
use Carbon\Carbon;

class FrontendController extends Controller
{
    protected $vedicAstroApi;

    public function __construct() {
        $this->vedicAstroApi = new VedicAstroApi();
    }
    
    public function index(){
        if(session()->has('get_kundli') && request('new') == 1){
            session()->forget('get_kundli');
        }
        return view("frontend\index");
    }

    public function get_kundli(Request $request){
        $data = [
            'full_name' => $request->full_name,
            'dob' => $request->dob,
            'tob' => $request->tob,
            'birth_place' => $request->birth_place,
            'gender' => $request->gender,
            'lat' => '23.25',
            'long' => '77.41',
        ];
        session(['get_kundli' => $data]);
        return redirect('full-details');
    }

    public function full_details(){
        return view("frontend/full-details");
    }

    public function chart_kundli(){
        // $data = session('get_kundli');
        $params = [
            'dob' => '08/11/1999',
            'tob' => '10:50',
            'lat' => 22,
            'lon' => 77,
            'tz' => 5.5,
            'lang' => 'hi'
        ];
        $kundli_data = $this->vedicAstroApi->getBirthChart($params);
        // $kundli_data = $this->vedicAstroApi->getManglicDosh($params);
        dd($kundli_data);
        return view("frontend/chart-kundli");
    }

   public function mangal_dosh() {
      $api_key = "2010326b-4c6f-5a01-90a0-31a33bc54b4e";
   
      $params = [
         'dob' => '08/11/1999',
         'tob' => '10:50',
         'lat' => 22,
         'lon' => 77,
         'tz' => 5.5,
         'api_key' => $api_key,
         'planet' => 'Jupiter',
         'lang' => 'hi'
      ];
      
      // API endpoint
      $baseUrl = 'https://api.vedicastroapi.com/v3-json/dosha/manglik-dosh';
      
      $queryString = http_build_query($params);
      $url = $baseUrl . '?' . $queryString;

      // Initialize cURL
      $ch = curl_init($url);
      
      // Set options
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

      // Execute the request
      $response = curl_exec($ch);

      dd(json_decode($response, true));
      
      // Check for errors
      if (curl_errno($ch)) {
         echo 'Error:' . curl_error($ch);
      } else {
         echo $response;
      }
      
      // Close the connection
      curl_close($ch);
   }

   public function va_planet_details(){
      $date = [];
      $api_key = "2010326b-4c6f-5a01-90a0-31a33bc54b4e";
      $params = [
         'dob' => '25/10/1987',
         'tob' => '05:05',
         'lat' => 26.76,
         'lon' => 78.78,
         'tz' => 5.5,
         'api_key' => $api_key,
         'lang' => 'hi'
      ];
      
      // API endpoint
      $baseUrl = 'https://api.vedicastroapi.com/v3-json/horoscope/planet-detail';
      
      $queryString = http_build_query($params);
      $url = $baseUrl . '?' . $queryString;

      // Initialize cURL
      $ch = curl_init($url);
      
      // Set options
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

      // Execute the request
      $response = curl_exec($ch);
      
      // Check for errors
      if (curl_errno($ch)) {
         echo 'Error:' . curl_error($ch);
      } else {
         dd($response); die;
      }
      
      // Close the connection
      curl_close($ch);
   }

    public function pk_access_token(){
        $pk_client_id = '4375751b-bf96-4022-ba20-23235e9d5756';
        $pk_client_secret = 'UZKo5kpnHTY3Nok9m68XUmfeyFy3hKutiWCyEl5F';
        $tokenUrl = 'https://api.prokerala.com/token';

        $ch = curl_init($tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'client_credentials',
            'client_id' => $pk_client_id,
            'client_secret' => $pk_client_secret,
        ]));
        $response = curl_exec($ch);
        return (json_decode($response, true)['access_token']);
    }

    public function pk_detailed_kundli(){
        $pk_client_id = 'd4064bb4-147b-49e2-b5c6-46d4e1e85145';
        $pk_client_secret = 'v33OejMtkQUmG5kzkoLAlnHmh5g1gblZ03KMFwY9';
        $access_token = $this->pk_access_token();
        // $access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJlMjhhMGZmYS1lZTE2LTRjMTktOWM1Ni1hMGYzODk0N2QyMDUiLCJqdGkiOiJiMTliNjkwMTM4ZTdjMmExZGU1NDY5MGVjNDc1NTE3Y2I0NGM5NDc";

        $url = 'https://api.prokerala.com/v2/astrology/kundli/advanced';
        $date = Carbon::createFromFormat('Y-m-d H:i:s', '1987-10-25 05:05:00', 'Asia/Kolkata');
        $data['ayanamsa'] = 1;
        $data['coordinates'] = '26.56,78.78';
        // rawurlencode
        $data['datetime'] = $date->toIso8601String();
        $data['la'] = 'hi';

        $query = http_build_query($data);
        $ch = curl_init("$url?$query");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $access_token"
        ]);
    
        $result = curl_exec($ch);
        curl_close($ch);

      //   $details = json_decode($result, true);
      //   print_r($details); die;
        print_r(($result)); die;
      //   $details = $details['data'];

        // Start output buffer
        ob_start();

        // 1. Nakshatra Details
        echo "<h2>नक्षत्र जानकारी</h2>";
        $nakshatra = $details['nakshatra_details']['nakshatra'];
        echo "नक्षत्र: {$nakshatra['name']}<br>";
        echo "पद: {$nakshatra['pada']}<br>";
        echo "स्वामी: {$nakshatra['lord']['name']} ({$nakshatra['lord']['vedic_name']})<br>";

        // 2. Mangal Dosha
        echo "<h2>मंगल दोष</h2>";
        $mangal = $details['mangal_dosha'];
        echo "मंगल दोष है: " . ($mangal['has_dosha'] ? "हाँ" : "नहीं") . "<br>";
        echo "विवरण: {$mangal['description']}<br>";
        echo "दोष प्रकार: {$mangal['type']}<br>";

        // 3. Yoga Details
        echo "<h2>योग विवरण</h2>";
        foreach ($details['yoga_details'] as $yoga) {
            echo "<h3>{$yoga['name']}</h3>";
            echo "<p>{$yoga['description']}</p>";
            if (!empty($yoga['yoga_list'])) {
                echo "<ul>";
                foreach ($yoga['yoga_list'] as $item) {
                    echo "<li>{$item}</li>"; // You can customize this based on structure
                }
                echo "</ul>";
            }
        }

        // 4. Dasha Periods
        echo "<h2>दशा विवरण</h2>";
        foreach ($details['dasha_periods'] as $dasha) {
            echo "<strong>{$dasha['name']}</strong>: {$dasha['start']} से {$dasha['end']}<br>";
        }

        // 5. Dasha Balance
        echo "<h2>दशा बैलेंस</h2>";
        $dashaBalance = $details['dasha_balance'];
        echo "स्वामी: {$dashaBalance['lord']['name']}<br>";
        echo "अवधि: {$dashaBalance['description']}<br>";

        // Get output
        $output = ob_get_clean();
        echo $output;
    }

    public function pk_planet_detailed(){
      $access_token = $this->pk_access_token();

        $url = 'https://api.prokerala.com/v2/astrology/planet-position';
        $date = Carbon::createFromFormat('Y-m-d H:i:s', '1987-10-25 05:05:00', 'Asia/Kolkata');
        $data['ayanamsa'] = 1;
        $data['coordinates'] = '26.56,78.78';
        // rawurlencode
        $data['datetime'] = $date->toIso8601String();
        $data['la'] = 'hi';

        $query = http_build_query($data);
        $ch = curl_init("$url?$query");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $access_token"
        ]);
    
        $result = curl_exec($ch);
        curl_close($ch);

      //   $details = json_decode($result, true);
      //   print_r($details); die;
        print_r(($result)); die;
    }

    public function pk_output(){
      $planet_details = [
         "status" => "ok",
         "data" => [
         "planet_position" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "longitude" => 187.33327656259,
         "is_retrograde" => false,
         "position" => 7,
         "degree" => 7.3332765625906,
         "rasi" => [
         "id" => 6,
         "name" => "तुला",
         "lord" => [
         "id" => 3,
         "name" => "शुक्र",
         "vedic_name" => "शुक्र"
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "longitude" => 215.52917939442,
         "is_retrograde" => false,
         "position" => 8,
         "degree" => 5.5291793944196,
         "rasi" => [
         "id" => 7,
         "name" => "वृश्चिक",
         "lord" => [
         "id" => 4,
         "name" => "मंगल",
         "vedic_name" => "मंगल"
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "longitude" => 194.77993978367,
         "is_retrograde" => true,
         "position" => 7,
         "degree" => 14.779939783673,
         "rasi" => [
         "id" => 6,
         "name" => "तुला",
         "lord" => [
         "id" => 3,
         "name" => "शुक्र",
         "vedic_name" => "शुक्र"
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "longitude" => 203.88964024189,
         "is_retrograde" => false,
         "position" => 7,
         "degree" => 23.88964024189,
         "rasi" => [
         "id" => 6,
         "name" => "तुला",
         "lord" => [
         "id" => 3,
         "name" => "शुक्र",
         "vedic_name" => "शुक्र"
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "longitude" => 166.72773052614,
         "is_retrograde" => false,
         "position" => 6,
         "degree" => 16.727730526143,
         "rasi" => [
         "id" => 5,
         "name" => "कन्या",
         "lord" => [
         "id" => 2,
         "name" => "बुध",
         "vedic_name" => "बुध"
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "longitude" => 0.12928010528075,
         "is_retrograde" => true,
         "position" => 1,
         "degree" => 0.12928010528075,
         "rasi" => [
         "id" => 0,
         "name" => "मेष",
         "lord" => [
         "id" => 4,
         "name" => "मंगल",
         "vedic_name" => "मंगल"
         ]
         ]
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "longitude" => 234.1911485184,
         "is_retrograde" => false,
         "position" => 8,
         "degree" => 24.191148518402,
         "rasi" => [
         "id" => 7,
         "name" => "वृश्चिक",
         "lord" => [
         "id" => 4,
         "name" => "मंगल",
         "vedic_name" => "मंगल"
         ]
         ]
         ],
         [
         "id" => 100,
         "name" => "लग्न",
         "longitude" => 170.05344636053,
         "is_retrograde" => false,
         "position" => 6,
         "degree" => 20.053446360534,
         "rasi" => [
         "id" => 5,
         "name" => "कन्या",
         "lord" => [
         "id" => 2,
         "name" => "बुध",
         "vedic_name" => "बुध"
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "longitude" => 337.08180358153,
         "is_retrograde" => true,
         "position" => 12,
         "degree" => 7.0818035815345,
         "rasi" => [
         "id" => 11,
         "name" => "मीन",
         "lord" => [
         "id" => 5,
         "name" => "गुरू",
         "vedic_name" => "गुरू"
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "longitude" => 157.08180358153,
         "is_retrograde" => true,
         "position" => 6,
         "degree" => 7.0818035815345,
         "rasi" => [
         "id" => 5,
         "name" => "कन्या",
         "lord" => [
         "id" => 2,
         "name" => "बुध",
         "vedic_name" => "बुध"
         ]
         ]
         ]
         ]
         ]
         ];
      
      $details = [
         "status" => "ok",
         "data" => [
         "nakshatra_details" => [
         "nakshatra" => [
         "id" => 16,
         "name" => "अनुराधा",
         "lord" => [
         "id" => 6,
         "name" => "शनि",
         "vedic_name" => "शनि"
         ],
         "pada" => 1
         ],
         "chandra_rasi" => [
         "id" => 7,
         "name" => "वृश्चिक",
         "lord" => [
         "id" => 4,
         "name" => "मंगल",
         "vedic_name" => "मंगल"
         ]
         ],
         "soorya_rasi" => [
         "id" => 6,
         "name" => "तुला",
         "lord" => [
         "id" => 3,
         "name" => "शुक्र",
         "vedic_name" => "शुक्र"
         ]
         ],
         "zodiac" => [
         "id" => 7,
         "name" => "वृश्चिक"
         ],
         "additional_info" => [
         "deity" => "मित्र",
         "ganam" => "देव गण",
         "symbol" => "कमल",
         "animal_sign" => "हरिण",
         "nadi" => "पित्त",
         "color" => "लालिमा लिए भूरा",
         "best_direction" => "दक्षिण",
         "syllables" => "ना, नी, नू, ने",
         "birth_stone" => "नीला पुखराज रत्",
         "gender" => "स्री",
         "planet" => "शनि",
         "enemy_yoni" => "कुत्ता"
         ]
         ],
         "mangal_dosha" => [
         "has_dosha" => true,
         "description" => "आपकी कुंडली में मंगल दोष है| मंगल जन्म कुंडली के 1 स्थान में स्थित है। यह निम्न मंगल दोष माना जाता है | ",
         "has_exception" => true,
         "type" => "कमजोर",
         "exceptions" => [
         "मंगल की अवधि जन्म से २८ साल की होती है और तदुपरांत मंगल के बुरे प्रभाव में कमी आ जाती है |"
         ],
         "remedies" => [
         `ऐसा माना जाता है कि यदि कोई मांगलिक व्यक्ति किसी अन्य मांगलिक व्यक्ति से विवाह करता है तो मांगलिक दोष रद्द हो जाता है और उसका कोई प्रभाव नहीं पड़ता है।",
         "प्रतिदिन हनुमान चालीसा का पाठ करके भगवान हनुमान की पूजा करें और मंगलवार को भगवान हनुमान के मंदिर में जाएं।",
         "मांगलिक दोष के दुष्प्रभाव को "कुंभ विवाह" करके रद्द किया जा सकता है जिसमें वास्तविक विवाह से पहले मांगलिक केले के पेड़, पीपल के पेड़ या भगवान विष्णु की मूर्ति से शादी करता है।",
         "विशेष पूजा, मंत्र, रत्न और दान के आवेदन से मांगलिक दोष के दुष्प्रभाव को कम किया जा सकता है।",
         "यदि स्वास्थ्य अनुमति दे तो हर तीन महीने में मंगलवार को रक्तदान करें।",
         "पक्षियों को कुछ मीठा खिलाएं।",
         "बरगद के पेड़ की पूजा किसी मीठी चीज में दूध मिलाकर करें।",
         "मंगलवार के दिन उगते चंद्रमा की अवधि में उपवास शुरू करें।`
         ]
         ],
         "yoga_details" => [
         [
         "name" => "विशेष और महत्वपूर्ण योग",
         "description" => "आपकी कुंडली में 3 महत्वपूर्ण योग हैं।",
         "yoga_list" => [
         [
         "name" => "गजकेसरी योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में गजकेसरी योग नहीं है।"
         ],
         [
         "name" => "केदार योग",
         "has_yoga" => true,
         "description" => "एक जातक के जन्म चार्ट में केदार योग उपस्थित होता है अगर सभी सातों ग्रह सही रूप से चार गृहों में उपस्थित हों| केदार योग वाले जातक को धन प्राप्ति और कृषि से आजीविका प्राप्त करने की काफी अधिक संभावनाएं हैं| इन जातकों में उत्तम विश्वसनीयता और बेहतरीन संचार कौशल होते हैं जिसके कारण वे बहुत अच्छे मित्र साबित होते है|"
         ],
         [
         "name" => "काहल योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में काहल योग नहीं है।"
         ],
         [
         "name" => "कमल योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में कमल योग नहीं है।"
         ],
         [
         "name" => "मूसल योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में मूसल योग नहीं है।"
         ],
         [
         "name" => "राज योग",
         "has_yoga" => true,
         "description" => "जब दो या दो से अधिक ग्रह ( जिनमें से कम से कम एक ग्रह ‘केंद्र ‘ का स्वामी होना चाहिए और दूसरा त्रिकोण का स्वामी होना चाहिए ) एक दूसरे के साथ संबन्धित होते हैं तब राजयोग निर्मित होता है | यह संबंध युति का हो सकता है, द्विदिशी दृष्टि अथवा राशि चक्र का हो सकता है | राजयोग वाले जातक को सामाजिक प्रतिष्ठा और प्रसिद्धि सहज ही प्राप्त होती है | विभिन्न मुद्दों पर उनके प्रयासों के लिए उन्हे पहचान और प्रशंसा मिलती है | इस चार्ट में सूर्य, बुध, शुक्र के बीच संबंध है |"
         ],
         [
         "name" => "रुचक योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में रुचक योग नहीं है।"
         ],
         [
         "name" => "भद्र योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में भद्र योग नहीं है।"
         ],
         [
         "name" => "हंसा योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में हंसा योग नहीं है।"
         ],
         [
         "name" => "मालव्य योग",
         "has_yoga" => true,
         "description" => "पंचमहापुरुष योगों मे से एक मालव्य योग वास्तव में एक शुभ योग है | जब शुक्र उच्च स्थान (मीन राशि मे) पर हो और किसी उच्च ग्रह या चंद्रमा से केंद्र स्थान मे स्थित हो अथवा स्वयं अपनी राशि (वृषभ या तुला) में हो तो जन्म कुंडली मे यह योग बनता है | जन्म कुंडली में शक्तिशाली शुक्र के स्थित होने से इस योग से अधिकतम लाभ हो सकता है | मालव्य योग में जन्मे जातक अपने जीवन मे सभी वस्तुओं के महत्व को समझते हैं, इसीलिए वे किसी भी चीज को साधारणत नही लेते और दूसरों को बहुत छोटे प्रतीत होने वाले सुख भी उनके लिए आनंदप्रद होते हैं | इस चार्ट मे, शुक्र स्व राशि में है | "
         ],
         [
         "name" => "सासा योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में सासा योग नहीं है।"
         ]
         ]
         ],
         [
         "name" => "चंद्र पर आधारित योग",
         "description" => "आपकी कुंडली में 1 चंद्र योग हैं।",
         "yoga_list" => [
         [
         "name" => "सुनफ़ योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में सुनफ़ योग नहीं है।"
         ],
         [
         "name" => "अनफ़ योग",
         "has_yoga" => true,
         "description" => "जब कोई लाभकारी ग्रह (सूर्य, राहू और केतू के अतिरिक्त) चंद्रमा से 12 वें गृह में होता है तब अनफ़ योग निर्मित होता है | अनफ़ योग वाले जातक का स्वास्थ्य अच्छा रहता है | वे अपनी बुद्धि और आकर्षण से लोगों को अपने पक्ष में करने में सफल रहते हैं | वे संचार अर्थात बातचीत में विशेष कुशल होते हैं और मानवीय और परोपकार संबंधी कार्यों में भी उनकी रूचि होती है | इस चार्ट में, बुध और शुक्र चंद्रमा से बारहवें गृह में हैं |"
         ],
         [
         "name" => "दुरुधारा योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में दुरुधारा योग नहीं है।"
         ],
         [
         "name" => "केमद्रुम योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में केमद्रुम योग नहीं है।"
         ]
         ]
         ],
         [
         "name" => "सूर्य पर आधारित योग",
         "description" => "आपकी कुंडली में 3 सूर्य योग हैं।",
         "yoga_list" => [
         [
         "name" => "वेशी योग",
         "has_yoga" => true,
         "description" => "जब बुध, शुक्र, मंगल, बृहस्पति या शनि सूर्य से द्वितीय गृह में होते हैं तो यह योग बनता है | इस योग में जन्म लेने वाले जातक लोगों के बीच भेद भाव नही करते | वे विशेष रूप से धार्मिक स्वभाव के होते हैं और सामान्यत निश्चिंत रहते हैं| इस चार्ट में, शनि सूर्य से दूसरे गृह में हैं |"
         ],
         [
         "name" => "वासी योग",
         "has_yoga" => true,
         "description" => "जब किसी की जन्म कुंडली में सूर्य से 12 वें गृह में राहू, केतू और चंद्रमा को छोडकर कोईअन्य ग्रह स्थित होता है तो यह योग बनता है |इस योग वाले जातकों को धन, वैभव और खुशी सहज ही प्राप्त होती है | इस योग में जन्मेजातकों का व्यक्तित्व आकर्षक होता है और वे प्रतिभाशाली, प्रखर बुद्धि वाले और परिश्रमी होतेहैं| वे ईमानदार और और अपनी बातों पर दृढ़ रहने वाले होते हैं | इस चार्ट में, मंगल सूर्य से 12वें गृह में हैं |"
         ],
         [
         "name" => "उभयचारी योग",
         "has_yoga" => true,
         "description" => "किसी की जन्म कुंडली में यह योग तब उपस्थित होता है जब सूर्य से द्वितीय और 12 वें गृह में राहू, केतू और चंद्रमा को छोडकर कोई अन्य ग्रह होता है | इस योग के जातकों का स्वास्थ्य अच्छा रहता है और वे मित्रो से घिरे रहते हैं | इस चार्ट में, मंगल, शनि सूर्य के दोनों ओर में है |"
         ]
         ]
         ],
         [
         "name" => "अशुभ योग",
         "description" => "आपकी कुंडली में 3 अशुभ योग हैं।",
         "yoga_list" => [
         [
         "name" => "दरिद्र योग",
         "has_yoga" => true,
         "description" => "िसी भी कुंडली के 11 वें, 9 वें और दूसरे गृह का संबंध धन और भाग्य से है | जब इन गृहों के स्वामियों का संबंध 6 ठे , 8 वें या 12 वें गृह या उनके स्वामियों से होता है तो दरिद्र योग निर्मित होता है| दरिद्र योग से राहत पाने के कुछ उपाय हैं – ऐसे जातक को अपने जन्मदिन, जन्म तिथि, जन्म नक्षत्र, अमावस्या और पुर्णिमा तिथि, मंगलवार, और दोपहर के बाद बाल कटवाने, बनवाने या छोटे नही करवाने चाहिए | दरिद्र योग के नकारात्मक प्रभाव को कम करने के लिए 11 वें गृह के स्वामी की विशिष्ट मंत्रों, यंत्रों और होम द्वारा पूजा करनी चाहिए| विशिष्ट दिवसों को उपवास रखना भी फलदायक साबित होगा| लक्ष्मी मंत्र भी दरिद्र योग को शांत करने के लिए सर्वोत्तम उपाय है | इस चार्ट में, शनि 8 स्थिति में है |"
         ],
         [
         "name" => "ग्रहण योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में ग्रहण योग नहीं है।"
         ],
         [
         "name" => "सकट योग",
         "has_yoga" => true,
         "description" => "सकट योग भी एक अशुभ योग है जिसमे बृहस्पति, चंद्रमा से 6ठे, 8वें या 12 वें गृह में स्थित होता है | इसके परिणामस्वरूप जातक के जीवन में असंतुष्टि और दुख रहता है | इस योग वाले जातक काफी अभिमानी होते हैं और इसीलिए उनके सच्चे मित्र नहीं बन पाते | इससे इस योग के जातक अधिकतर उदास और अकेलापन महसूस करते हैं | सकट योग के प्रभाव को कम करने के कुछ उपाय निम्नलिखित हैं- सोमवार और गुरुवार को उपवास करना चाहिए | साथ ही, सोमवार को देवी गौरी और उसके बाद गुरुवार को भगवान शिव की पूजा करनी चाहिए | इसके अतिरिक्त, किसी मंदिर में सेवा करनी चाहिए अथवा किसी धर्मार्थ संस्थान में रविवार को या जब कभी भी संभव हो सके, सेवा करनी चाहिए | इस चार्ट में, बृहस्पति, चंद्रमा से 6 गृह में है | "
         ],
         [
         "name" => "चांडाल योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में चांडाल योग नहीं है।"
         ],
         [
         "name" => "कुज योग",
         "has_yoga" => true,
         "description" => "कुज योग को मंगल दोष और मांगलिक दोष के नाम से भी जाना जाता है और यह तब निर्मित होता है जब किसी चार्ट में मंगल पहले, चौथे, सातवें, आठवें अथवा बारहवें गृह में हो | मंगल देवता को प्रसन्न करने के लिए कुछ उपाय निम्नलिखित हैं – जब दो कुज दोष वाले लोग आपस में विवाह करते हैं तो कुज दोष का नकारात्मक प्रभाव समाप्त हो जाता है | नवग्रह मंत्र जाप, गायत्री मंत्र का जाप, हनुमान चालीसा का जाप और ध्यान करने से काफी लाभ मिलता है | मंगलवार को हनुमानजी की पूजा करने और हनुमानजी के मंदिर में जाने से मंगल दोष काफी हद तक कम हो जाता है | मंगलवार का व्रत करने से भी फायदा होगा | इस चार्ट में मंगल केंद्र में है | "
         ],
         [
         "name" => "केमद्रुम योग",
         "has_yoga" => false,
         "description" => "आपकी कुंडली में केमद्रुम योग नहीं है।"
         ]
         ]
         ]
         ],
         "dasha_periods" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1984-09-07T07:33:45+05:30",
         "end" => "2003-09-08T01:33:44+05:30",
         "antardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1984-09-07T07:33:45+05:30",
         "end" => "1987-09-11T02:36:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1984-09-07T07:33:45+05:30",
         "end" => "1985-02-28T06:58:42+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "1985-02-28T06:58:43+05:30",
         "end" => "1985-08-02T22:52:37+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "1985-08-02T22:52:38+05:30",
         "end" => "1985-10-06T01:11:17+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "1985-10-06T01:11:18+05:30",
         "end" => "1986-04-07T04:21:47+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "1986-04-07T04:21:48+05:30",
         "end" => "1986-06-01T02:54:56+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "1986-06-01T02:54:57+05:30",
         "end" => "1986-08-31T16:30:11+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "1986-08-31T16:30:12+05:30",
         "end" => "1986-11-03T18:48:51+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "1986-11-03T18:48:52+05:30",
         "end" => "1987-04-17T14:28:18+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "1987-04-17T14:28:19+05:30",
         "end" => "1987-09-11T02:36:42+05:30"
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "1987-09-11T02:36:45+05:30",
         "end" => "1990-05-21T05:45:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "1987-09-11T02:36:45+05:30",
         "end" => "1988-01-28T09:15:30+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "1988-01-28T09:15:31+05:30",
         "end" => "1988-03-25T17:38:31+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "1988-03-25T17:38:32+05:30",
         "end" => "1988-09-05T14:10:01+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "1988-09-05T14:10:02+05:30",
         "end" => "1988-10-24T17:55:28+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "1988-10-24T17:55:29+05:30",
         "end" => "1989-01-14T16:11:13+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "1989-01-14T16:11:14+05:30",
         "end" => "1989-03-13T00:34:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "1989-03-13T00:34:15+05:30",
         "end" => "1989-08-07T11:50:35+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "1989-08-07T11:50:36+05:30",
         "end" => "1989-12-16T13:51:47+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1989-12-16T13:51:48+05:30",
         "end" => "1990-05-21T05:45:42+05:30"
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "1990-05-21T05:45:45+05:30",
         "end" => "1991-06-30T01:24:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "1990-05-21T05:45:45+05:30",
         "end" => "1990-06-13T20:30:30+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "1990-06-13T20:30:31+05:30",
         "end" => "1990-08-20T07:47:00+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "1990-08-20T07:47:01+05:30",
         "end" => "1990-09-09T13:33:57+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "1990-09-09T13:33:58+05:30",
         "end" => "1990-10-13T07:12:12+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "1990-10-13T07:12:13+05:30",
         "end" => "1990-11-05T21:56:58+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "1990-11-05T21:56:59+05:30",
         "end" => "1991-01-05T15:17:49+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "1991-01-05T15:17:50+05:30",
         "end" => "1991-02-28T14:43:01+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1991-02-28T14:43:02+05:30",
         "end" => "1991-05-03T17:01:41+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "1991-05-03T17:01:42+05:30",
         "end" => "1991-06-30T01:24:42+05:30"
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "1991-06-30T01:24:45+05:30",
         "end" => "1994-08-29T16:24:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "1991-06-30T01:24:45+05:30",
         "end" => "1992-01-08T19:54:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "1992-01-08T19:54:45+05:30",
         "end" => "1992-03-06T15:51:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "1992-03-06T15:51:45+05:30",
         "end" => "1992-06-11T01:06:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "1992-06-11T01:06:45+05:30",
         "end" => "1992-08-17T12:23:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "1992-08-17T12:23:15+05:30",
         "end" => "1993-02-07T00:14:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "1993-02-07T00:14:15+05:30",
         "end" => "1993-07-11T05:26:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1993-07-11T05:26:15+05:30",
         "end" => "1994-01-10T08:36:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "1994-01-10T08:36:45+05:30",
         "end" => "1994-06-23T05:08:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "1994-06-23T05:08:15+05:30",
         "end" => "1994-08-29T16:24:44+05:30"
         ]
         ]
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "1994-08-29T16:24:45+05:30",
         "end" => "1995-08-11T16:06:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "1994-08-29T16:24:45+05:30",
         "end" => "1994-09-16T00:47:50+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "1994-09-16T00:47:51+05:30",
         "end" => "1994-10-14T22:46:20+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "1994-10-14T22:46:21+05:30",
         "end" => "1994-11-04T04:33:17+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "1994-11-04T04:33:18+05:30",
         "end" => "1994-12-26T05:42:35+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "1994-12-26T05:42:36+05:30",
         "end" => "1995-02-10T12:04:11+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1995-02-10T12:04:12+05:30",
         "end" => "1995-04-06T10:37:20+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "1995-04-06T10:37:21+05:30",
         "end" => "1995-05-25T14:22:47+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "1995-05-25T14:22:48+05:30",
         "end" => "1995-06-14T20:09:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "1995-06-14T20:09:45+05:30",
         "end" => "1995-08-11T16:06:44+05:30"
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "1995-08-11T16:06:45+05:30",
         "end" => "1997-03-11T23:36:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "1995-08-11T16:06:45+05:30",
         "end" => "1995-09-28T20:44:14+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "1995-09-28T20:44:15+05:30",
         "end" => "1995-11-01T14:22:29+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "1995-11-01T14:22:30+05:30",
         "end" => "1996-01-27T08:17:59+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "1996-01-27T08:18:00+05:30",
         "end" => "1996-04-13T10:53:59+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1996-04-13T10:54:00+05:30",
         "end" => "1996-07-14T00:29:14+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "1996-07-14T00:29:15+05:30",
         "end" => "1996-10-03T22:44:59+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "1996-10-03T22:45:00+05:30",
         "end" => "1996-11-06T16:23:14+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "1996-11-06T16:23:15+05:30",
         "end" => "1997-02-11T01:38:14+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "1997-02-11T01:38:15+05:30",
         "end" => "1997-03-11T23:36:44+05:30"
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "1997-03-11T23:36:45+05:30",
         "end" => "1998-04-20T19:15:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "1997-03-11T23:36:45+05:30",
         "end" => "1997-04-04T14:21:30+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "1997-04-04T14:21:31+05:30",
         "end" => "1997-06-04T07:42:21+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "1997-06-04T07:42:22+05:30",
         "end" => "1997-07-28T07:07:33+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1997-07-28T07:07:34+05:30",
         "end" => "1997-09-30T09:26:13+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "1997-09-30T09:26:14+05:30",
         "end" => "1997-11-26T17:49:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "1997-11-26T17:49:15+05:30",
         "end" => "1997-12-20T08:34:00+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "1997-12-20T08:34:01+05:30",
         "end" => "1998-02-25T19:50:30+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "1998-02-25T19:50:31+05:30",
         "end" => "1998-03-18T01:37:27+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "1998-03-18T01:37:28+05:30",
         "end" => "1998-04-20T19:15:42+05:30"
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "1998-04-20T19:15:45+05:30",
         "end" => "2001-02-24T18:21:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "1998-04-20T19:15:45+05:30",
         "end" => "1998-09-23T22:43:38+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "1998-09-23T22:43:39+05:30",
         "end" => "1999-02-09T17:48:26+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "1999-02-09T17:48:27+05:30",
         "end" => "1999-07-24T13:27:53+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "1999-07-24T13:27:54+05:30",
         "end" => "1999-12-19T00:44:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "1999-12-19T00:44:15+05:30",
         "end" => "2000-02-17T18:05:05+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2000-02-17T18:05:06+05:30",
         "end" => "2000-08-09T05:56:05+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2000-08-09T05:56:06+05:30",
         "end" => "2000-09-30T07:05:23+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2000-09-30T07:05:24+05:30",
         "end" => "2000-12-26T01:00:53+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2000-12-26T01:00:54+05:30",
         "end" => "2001-02-24T18:21:44+05:30"
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2001-02-24T18:21:45+05:30",
         "end" => "2003-09-08T01:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2001-02-24T18:21:45+05:30",
         "end" => "2001-06-28T03:19:20+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2001-06-28T03:19:21+05:30",
         "end" => "2001-11-21T15:27:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2001-11-21T15:27:45+05:30",
         "end" => "2002-04-01T17:28:56+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2002-04-01T17:28:57+05:30",
         "end" => "2002-05-25T16:54:08+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2002-05-25T16:54:09+05:30",
         "end" => "2002-10-26T22:06:08+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2002-10-26T22:06:09+05:30",
         "end" => "2002-12-12T04:27:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2002-12-12T04:27:45+05:30",
         "end" => "2003-02-27T07:03:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2003-02-27T07:03:45+05:30",
         "end" => "2003-04-22T06:28:56+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2003-04-22T06:28:57+05:30",
         "end" => "2003-09-08T01:33:44+05:30"
         ]
         ]
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2003-09-08T01:33:45+05:30",
         "end" => "2020-09-07T07:33:44+05:30",
         "antardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2003-09-08T01:33:45+05:30",
         "end" => "2006-02-03T17:00:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2003-09-08T01:33:45+05:30",
         "end" => "2004-01-10T16:21:03+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2004-01-10T16:21:04+05:30",
         "end" => "2004-03-01T23:51:07+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2004-03-01T23:51:08+05:30",
         "end" => "2004-07-26T14:25:37+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2004-07-26T14:25:38+05:30",
         "end" => "2004-09-08T13:59:58+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2004-09-08T13:59:59+05:30",
         "end" => "2004-11-20T21:17:13+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2004-11-20T21:17:14+05:30",
         "end" => "2005-01-11T04:47:17+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2005-01-11T04:47:18+05:30",
         "end" => "2005-05-23T03:30:20+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2005-05-23T03:30:21+05:30",
         "end" => "2005-09-17T10:21:56+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2005-09-17T10:21:57+05:30",
         "end" => "2006-02-03T17:00:42+05:30"
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2006-02-03T17:00:45+05:30",
         "end" => "2007-01-31T21:57:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2006-02-03T17:00:45+05:30",
         "end" => "2006-02-24T20:06:03+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2006-02-24T20:06:04+05:30",
         "end" => "2006-04-26T04:55:33+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2006-04-26T04:55:34+05:30",
         "end" => "2006-05-14T07:34:24+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2006-05-14T07:34:25+05:30",
         "end" => "2006-06-13T11:59:09+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2006-06-13T11:59:10+05:30",
         "end" => "2006-07-04T15:04:28+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2006-07-04T15:04:29+05:30",
         "end" => "2006-08-27T23:01:01+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2006-08-27T23:01:02+05:30",
         "end" => "2006-10-15T06:04:37+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2006-10-15T06:04:38+05:30",
         "end" => "2006-12-11T14:27:38+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2006-12-11T14:27:39+05:30",
         "end" => "2007-01-31T21:57:42+05:30"
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2007-01-31T21:57:45+05:30",
         "end" => "2009-12-01T18:57:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2007-01-31T21:57:45+05:30",
         "end" => "2007-07-23T09:27:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2007-07-23T09:27:45+05:30",
         "end" => "2007-09-13T03:18:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2007-09-13T03:18:45+05:30",
         "end" => "2007-12-08T09:03:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2007-12-08T09:03:45+05:30",
         "end" => "2008-02-06T17:53:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2008-02-06T17:53:15+05:30",
         "end" => "2008-07-10T23:26:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2008-07-10T23:26:15+05:30",
         "end" => "2008-11-25T23:02:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2008-11-25T23:02:15+05:30",
         "end" => "2009-05-08T19:33:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2009-05-08T19:33:45+05:30",
         "end" => "2009-10-02T10:08:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2009-10-02T10:08:15+05:30",
         "end" => "2009-12-01T18:57:44+05:30"
         ]
         ]
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2009-12-01T18:57:45+05:30",
         "end" => "2010-10-08T06:03:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2009-12-01T18:57:45+05:30",
         "end" => "2009-12-17T07:31:02+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2009-12-17T07:31:03+05:30",
         "end" => "2010-01-12T04:26:32+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2010-01-12T04:26:33+05:30",
         "end" => "2010-01-30T07:05:23+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2010-01-30T07:05:24+05:30",
         "end" => "2010-03-17T20:45:17+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2010-03-17T20:45:18+05:30",
         "end" => "2010-04-28T06:14:05+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2010-04-28T06:14:06+05:30",
         "end" => "2010-06-16T09:59:32+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2010-06-16T09:59:33+05:30",
         "end" => "2010-07-30T09:33:53+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2010-07-30T09:33:54+05:30",
         "end" => "2010-08-17T12:12:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2010-08-17T12:12:45+05:30",
         "end" => "2010-10-08T06:03:44+05:30"
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2010-10-08T06:03:45+05:30",
         "end" => "2012-03-08T16:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2010-10-08T06:03:45+05:30",
         "end" => "2010-11-20T08:56:14+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2010-11-20T08:56:15+05:30",
         "end" => "2010-12-20T13:20:59+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2010-12-20T13:21:00+05:30",
         "end" => "2011-03-08T04:07:29+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2011-03-08T04:07:30+05:30",
         "end" => "2011-05-16T03:55:29+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2011-05-16T03:55:30+05:30",
         "end" => "2011-08-06T02:11:14+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2011-08-06T02:11:15+05:30",
         "end" => "2011-10-18T09:28:29+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2011-10-18T09:28:30+05:30",
         "end" => "2011-11-17T13:53:14+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2011-11-17T13:53:15+05:30",
         "end" => "2012-02-11T19:38:14+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2012-02-11T19:38:15+05:30",
         "end" => "2012-03-08T16:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2012-03-08T16:33:45+05:30",
         "end" => "2013-03-05T21:30:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2012-03-08T16:33:45+05:30",
         "end" => "2012-03-29T19:39:03+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2012-03-29T19:39:04+05:30",
         "end" => "2012-05-23T03:35:36+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2012-05-23T03:35:37+05:30",
         "end" => "2012-07-10T10:39:12+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2012-07-10T10:39:13+05:30",
         "end" => "2012-09-05T19:02:13+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2012-09-05T19:02:14+05:30",
         "end" => "2012-10-27T02:32:17+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2012-10-27T02:32:18+05:30",
         "end" => "2012-11-17T05:37:36+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2012-11-17T05:37:37+05:30",
         "end" => "2013-01-16T14:27:06+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2013-01-16T14:27:07+05:30",
         "end" => "2013-02-03T17:05:57+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2013-02-03T17:05:58+05:30",
         "end" => "2013-03-05T21:30:42+05:30"
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2013-03-05T21:30:45+05:30",
         "end" => "2015-09-23T06:48:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2013-03-05T21:30:45+05:30",
         "end" => "2013-07-23T14:30:26+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2013-07-23T14:30:27+05:30",
         "end" => "2013-11-24T18:56:50+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2013-11-24T18:56:51+05:30",
         "end" => "2014-04-21T06:13:11+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2014-04-21T06:13:12+05:30",
         "end" => "2014-08-31T04:56:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2014-08-31T04:56:15+05:30",
         "end" => "2014-10-24T12:52:47+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2014-10-24T12:52:48+05:30",
         "end" => "2015-03-28T18:25:47+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2015-03-28T18:25:48+05:30",
         "end" => "2015-05-14T08:05:41+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2015-05-14T08:05:42+05:30",
         "end" => "2015-07-30T22:52:11+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2015-07-30T22:52:12+05:30",
         "end" => "2015-09-23T06:48:44+05:30"
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2015-09-23T06:48:45+05:30",
         "end" => "2017-12-29T04:24:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2015-09-23T06:48:45+05:30",
         "end" => "2016-01-11T16:05:32+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2016-01-11T16:05:33+05:30",
         "end" => "2016-05-21T18:06:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2016-05-21T18:06:45+05:30",
         "end" => "2016-09-16T00:58:20+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2016-09-16T00:58:21+05:30",
         "end" => "2016-11-03T08:01:56+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2016-11-03T08:01:57+05:30",
         "end" => "2017-03-21T07:37:56+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2017-03-21T07:37:57+05:30",
         "end" => "2017-05-01T17:06:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2017-05-01T17:06:45+05:30",
         "end" => "2017-07-09T16:54:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2017-07-09T16:54:45+05:30",
         "end" => "2017-08-26T23:58:20+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2017-08-26T23:58:21+05:30",
         "end" => "2017-12-29T04:24:44+05:30"
         ]
         ]
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2017-12-29T04:24:45+05:30",
         "end" => "2020-09-07T07:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2017-12-29T04:24:45+05:30",
         "end" => "2018-06-02T20:18:39+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2018-06-02T20:18:40+05:30",
         "end" => "2018-10-20T02:57:25+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2018-10-20T02:57:26+05:30",
         "end" => "2018-12-16T11:20:26+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2018-12-16T11:20:27+05:30",
         "end" => "2019-05-29T07:51:56+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2019-05-29T07:51:57+05:30",
         "end" => "2019-07-17T11:37:23+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2019-07-17T11:37:24+05:30",
         "end" => "2019-10-07T09:53:08+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2019-10-07T09:53:09+05:30",
         "end" => "2019-12-03T18:16:09+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2019-12-03T18:16:10+05:30",
         "end" => "2020-04-29T05:32:30+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2020-04-29T05:32:31+05:30",
         "end" => "2020-09-07T07:33:42+05:30"
         ]
         ]
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2020-09-07T07:33:45+05:30",
         "end" => "2027-09-08T01:33:44+05:30",
         "antardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2020-09-07T07:33:45+05:30",
         "end" => "2021-02-03T11:00:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2020-09-07T07:33:45+05:30",
         "end" => "2020-09-16T00:21:48+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2020-09-16T00:21:49+05:30",
         "end" => "2020-10-10T20:56:18+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2020-10-10T20:56:19+05:30",
         "end" => "2020-10-18T07:54:39+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2020-10-18T07:54:40+05:30",
         "end" => "2020-10-30T18:11:54+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2020-10-30T18:11:55+05:30",
         "end" => "2020-11-08T10:59:58+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2020-11-08T10:59:59+05:30",
         "end" => "2020-11-30T19:55:01+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2020-11-30T19:55:02+05:30",
         "end" => "2020-12-20T17:10:37+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2020-12-20T17:10:38+05:30",
         "end" => "2021-01-13T07:55:23+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2021-01-13T07:55:24+05:30",
         "end" => "2021-02-03T11:00:42+05:30"
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2021-02-03T11:00:45+05:30",
         "end" => "2022-04-05T14:00:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2021-02-03T11:00:45+05:30",
         "end" => "2021-04-15T11:30:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2021-04-15T11:30:45+05:30",
         "end" => "2021-05-06T18:51:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2021-05-06T18:51:45+05:30",
         "end" => "2021-06-11T07:06:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2021-06-11T07:06:45+05:30",
         "end" => "2021-07-06T03:41:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2021-07-06T03:41:15+05:30",
         "end" => "2021-09-08T01:44:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2021-09-08T01:44:15+05:30",
         "end" => "2021-11-03T21:20:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2021-11-03T21:20:15+05:30",
         "end" => "2022-01-10T08:36:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2022-01-10T08:36:45+05:30",
         "end" => "2022-03-11T17:26:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2022-03-11T17:26:15+05:30",
         "end" => "2022-04-05T14:00:44+05:30"
         ]
         ]
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2022-04-05T14:00:45+05:30",
         "end" => "2022-08-11T10:06:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2022-04-05T14:00:45+05:30",
         "end" => "2022-04-11T23:25:02+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2022-04-11T23:25:03+05:30",
         "end" => "2022-04-22T15:05:32+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2022-04-22T15:05:33+05:30",
         "end" => "2022-04-30T02:03:53+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2022-04-30T02:03:54+05:30",
         "end" => "2022-05-19T06:16:47+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2022-05-19T06:16:48+05:30",
         "end" => "2022-06-05T07:21:35+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2022-06-05T07:21:36+05:30",
         "end" => "2022-06-25T13:08:32+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2022-06-25T13:08:33+05:30",
         "end" => "2022-07-13T15:47:23+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2022-07-13T15:47:24+05:30",
         "end" => "2022-07-21T02:45:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2022-07-21T02:45:45+05:30",
         "end" => "2022-08-11T10:06:44+05:30"
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2022-08-11T10:06:45+05:30",
         "end" => "2023-03-12T11:36:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2022-08-11T10:06:45+05:30",
         "end" => "2022-08-29T04:14:14+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2022-08-29T04:14:15+05:30",
         "end" => "2022-09-10T14:31:29+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2022-09-10T14:31:30+05:30",
         "end" => "2022-10-12T13:32:59+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2022-10-12T13:33:00+05:30",
         "end" => "2022-11-09T23:20:59+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2022-11-09T23:21:00+05:30",
         "end" => "2022-12-13T16:59:14+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2022-12-13T16:59:15+05:30",
         "end" => "2023-01-12T21:23:59+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2023-01-12T21:24:00+05:30",
         "end" => "2023-01-25T07:41:14+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2023-01-25T07:41:15+05:30",
         "end" => "2023-03-01T19:56:14+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2023-03-01T19:56:15+05:30",
         "end" => "2023-03-12T11:36:44+05:30"
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2023-03-12T11:36:45+05:30",
         "end" => "2023-08-08T15:03:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2023-03-12T11:36:45+05:30",
         "end" => "2023-03-21T04:24:48+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2023-03-21T04:24:49+05:30",
         "end" => "2023-04-12T13:19:51+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2023-04-12T13:19:52+05:30",
         "end" => "2023-05-02T10:35:27+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2023-05-02T10:35:28+05:30",
         "end" => "2023-05-26T01:20:13+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2023-05-26T01:20:14+05:30",
         "end" => "2023-06-16T04:25:32+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2023-06-16T04:25:33+05:30",
         "end" => "2023-06-24T21:13:36+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2023-06-24T21:13:37+05:30",
         "end" => "2023-07-19T17:48:06+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2023-07-19T17:48:07+05:30",
         "end" => "2023-07-27T04:46:27+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2023-07-27T04:46:28+05:30",
         "end" => "2023-08-08T15:03:42+05:30"
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2023-08-08T15:03:45+05:30",
         "end" => "2024-08-26T03:21:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2023-08-08T15:03:45+05:30",
         "end" => "2023-10-05T03:42:26+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2023-10-05T03:42:27+05:30",
         "end" => "2023-11-25T06:56:50+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2023-11-25T06:56:51+05:30",
         "end" => "2024-01-25T00:17:41+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2024-01-25T00:17:42+05:30",
         "end" => "2024-03-19T08:14:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2024-03-19T08:14:15+05:30",
         "end" => "2024-04-10T17:09:17+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2024-04-10T17:09:18+05:30",
         "end" => "2024-06-13T15:12:17+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2024-06-13T15:12:18+05:30",
         "end" => "2024-07-02T19:25:11+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2024-07-02T19:25:12+05:30",
         "end" => "2024-08-03T18:26:41+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2024-08-03T18:26:42+05:30",
         "end" => "2024-08-26T03:21:44+05:30"
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2024-08-26T03:21:45+05:30",
         "end" => "2025-08-02T00:57:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2024-08-26T03:21:45+05:30",
         "end" => "2024-10-10T14:14:32+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2024-10-10T14:14:33+05:30",
         "end" => "2024-12-03T13:39:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2024-12-03T13:39:45+05:30",
         "end" => "2025-01-20T20:43:20+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2025-01-20T20:43:21+05:30",
         "end" => "2025-02-09T17:58:56+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2025-02-09T17:58:57+05:30",
         "end" => "2025-04-07T13:34:56+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2025-04-07T13:34:57+05:30",
         "end" => "2025-04-24T14:39:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2025-04-24T14:39:45+05:30",
         "end" => "2025-05-23T00:27:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2025-05-23T00:27:45+05:30",
         "end" => "2025-06-11T21:43:20+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2025-06-11T21:43:21+05:30",
         "end" => "2025-08-02T00:57:44+05:30"
         ]
         ]
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2025-08-02T00:57:45+05:30",
         "end" => "2026-09-10T20:36:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2025-08-02T00:57:45+05:30",
         "end" => "2025-10-05T03:16:24+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2025-10-05T03:16:25+05:30",
         "end" => "2025-12-01T11:39:25+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2025-12-01T11:39:26+05:30",
         "end" => "2025-12-25T02:24:11+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2025-12-25T02:24:12+05:30",
         "end" => "2026-03-02T13:40:41+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2026-03-02T13:40:42+05:30",
         "end" => "2026-03-22T19:27:38+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2026-03-22T19:27:39+05:30",
         "end" => "2026-04-25T13:05:53+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2026-04-25T13:05:54+05:30",
         "end" => "2026-05-19T03:50:39+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2026-05-19T03:50:40+05:30",
         "end" => "2026-07-18T21:11:30+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2026-07-18T21:11:31+05:30",
         "end" => "2026-09-10T20:36:42+05:30"
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2026-09-10T20:36:45+05:30",
         "end" => "2027-09-08T01:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2026-09-10T20:36:45+05:30",
         "end" => "2026-11-01T04:06:48+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2026-11-01T04:06:49+05:30",
         "end" => "2026-11-22T07:12:07+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2026-11-22T07:12:08+05:30",
         "end" => "2027-01-21T16:01:37+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2027-01-21T16:01:38+05:30",
         "end" => "2027-02-08T18:40:28+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2027-02-08T18:40:29+05:30",
         "end" => "2027-03-10T23:05:13+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2027-03-10T23:05:14+05:30",
         "end" => "2027-04-01T02:10:32+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2027-04-01T02:10:33+05:30",
         "end" => "2027-05-25T10:07:05+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2027-05-25T10:07:06+05:30",
         "end" => "2027-07-12T17:10:41+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2027-07-12T17:10:42+05:30",
         "end" => "2027-09-08T01:33:42+05:30"
         ]
         ]
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2027-09-08T01:33:45+05:30",
         "end" => "2047-09-08T01:33:44+05:30",
         "antardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2027-09-08T01:33:45+05:30",
         "end" => "2031-01-07T13:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2027-09-08T01:33:45+05:30",
         "end" => "2028-03-28T23:33:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2028-03-28T23:33:45+05:30",
         "end" => "2028-05-28T20:33:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2028-05-28T20:33:45+05:30",
         "end" => "2028-09-07T07:33:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2028-09-07T07:33:45+05:30",
         "end" => "2028-11-17T08:03:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2028-11-17T08:03:45+05:30",
         "end" => "2029-05-18T23:03:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2029-05-18T23:03:45+05:30",
         "end" => "2029-10-28T07:03:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2029-10-28T07:03:45+05:30",
         "end" => "2030-05-09T01:33:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2030-05-09T01:33:45+05:30",
         "end" => "2030-10-28T13:03:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2030-10-28T13:03:45+05:30",
         "end" => "2031-01-07T13:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2031-01-07T13:33:45+05:30",
         "end" => "2032-01-07T19:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2031-01-07T13:33:45+05:30",
         "end" => "2031-01-25T19:51:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2031-01-25T19:51:45+05:30",
         "end" => "2031-02-25T06:21:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2031-02-25T06:21:45+05:30",
         "end" => "2031-03-18T13:42:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2031-03-18T13:42:45+05:30",
         "end" => "2031-05-12T08:36:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2031-05-12T08:36:45+05:30",
         "end" => "2031-06-30T01:24:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2031-06-30T01:24:45+05:30",
         "end" => "2031-08-26T21:21:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2031-08-26T21:21:45+05:30",
         "end" => "2031-10-17T15:12:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2031-10-17T15:12:45+05:30",
         "end" => "2031-11-07T22:33:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2031-11-07T22:33:45+05:30",
         "end" => "2032-01-07T19:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2032-01-07T19:33:45+05:30",
         "end" => "2033-09-07T13:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2032-01-07T19:33:45+05:30",
         "end" => "2032-02-27T13:03:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2032-02-27T13:03:45+05:30",
         "end" => "2032-04-03T01:18:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2032-04-03T01:18:45+05:30",
         "end" => "2032-07-03T08:48:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2032-07-03T08:48:45+05:30",
         "end" => "2032-09-22T12:48:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2032-09-22T12:48:45+05:30",
         "end" => "2032-12-27T22:03:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2032-12-27T22:03:45+05:30",
         "end" => "2033-03-24T03:48:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2033-03-24T03:48:45+05:30",
         "end" => "2033-04-28T16:03:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2033-04-28T16:03:45+05:30",
         "end" => "2033-08-08T03:03:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2033-08-08T03:03:45+05:30",
         "end" => "2033-09-07T13:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2033-09-07T13:33:45+05:30",
         "end" => "2034-11-07T16:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2033-09-07T13:33:45+05:30",
         "end" => "2033-10-02T10:08:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2033-10-02T10:08:15+05:30",
         "end" => "2033-12-05T08:11:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2033-12-05T08:11:15+05:30",
         "end" => "2034-01-31T03:47:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2034-01-31T03:47:15+05:30",
         "end" => "2034-04-08T15:03:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2034-04-08T15:03:45+05:30",
         "end" => "2034-06-07T23:53:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2034-06-07T23:53:15+05:30",
         "end" => "2034-07-02T20:27:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2034-07-02T20:27:45+05:30",
         "end" => "2034-09-11T20:57:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2034-09-11T20:57:45+05:30",
         "end" => "2034-10-03T04:18:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2034-10-03T04:18:45+05:30",
         "end" => "2034-11-07T16:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2034-11-07T16:33:45+05:30",
         "end" => "2037-11-07T10:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2034-11-07T16:33:45+05:30",
         "end" => "2035-04-21T01:15:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2035-04-21T01:15:45+05:30",
         "end" => "2035-09-14T03:39:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2035-09-14T03:39:45+05:30",
         "end" => "2036-03-05T15:30:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2036-03-05T15:30:45+05:30",
         "end" => "2036-08-07T21:03:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2036-08-07T21:03:45+05:30",
         "end" => "2036-10-10T19:06:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2036-10-10T19:06:45+05:30",
         "end" => "2037-04-11T10:06:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2037-04-11T10:06:45+05:30",
         "end" => "2037-06-05T05:00:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2037-06-05T05:00:45+05:30",
         "end" => "2037-09-04T12:30:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2037-09-04T12:30:45+05:30",
         "end" => "2037-11-07T10:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2037-11-07T10:33:45+05:30",
         "end" => "2040-07-08T10:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2037-11-07T10:33:45+05:30",
         "end" => "2038-03-17T07:21:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2038-03-17T07:21:45+05:30",
         "end" => "2038-08-18T12:33:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2038-08-18T12:33:45+05:30",
         "end" => "2039-01-03T12:09:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2039-01-03T12:09:45+05:30",
         "end" => "2039-03-01T07:45:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2039-03-01T07:45:45+05:30",
         "end" => "2039-08-10T15:45:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2039-08-10T15:45:45+05:30",
         "end" => "2039-09-28T08:33:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2039-09-28T08:33:45+05:30",
         "end" => "2039-12-18T12:33:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2039-12-18T12:33:45+05:30",
         "end" => "2040-02-13T08:09:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2040-02-13T08:09:45+05:30",
         "end" => "2040-07-08T10:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2040-07-08T10:33:45+05:30",
         "end" => "2043-09-08T01:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2040-07-08T10:33:45+05:30",
         "end" => "2041-01-07T13:44:14+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2041-01-07T13:44:15+05:30",
         "end" => "2041-06-20T10:15:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2041-06-20T10:15:45+05:30",
         "end" => "2041-08-26T21:32:14+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2041-08-26T21:32:15+05:30",
         "end" => "2042-03-07T16:02:14+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2042-03-07T16:02:15+05:30",
         "end" => "2042-05-04T11:59:14+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2042-05-04T11:59:15+05:30",
         "end" => "2042-08-08T21:14:14+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2042-08-08T21:14:15+05:30",
         "end" => "2042-10-15T08:30:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2042-10-15T08:30:45+05:30",
         "end" => "2043-04-06T20:21:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2043-04-06T20:21:45+05:30",
         "end" => "2043-09-08T01:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2043-09-08T01:33:45+05:30",
         "end" => "2046-07-08T22:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2043-09-08T01:33:45+05:30",
         "end" => "2044-02-01T16:08:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2044-02-01T16:08:15+05:30",
         "end" => "2044-04-02T00:57:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2044-04-02T00:57:45+05:30",
         "end" => "2044-09-21T12:27:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2044-09-21T12:27:45+05:30",
         "end" => "2044-11-12T06:18:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2044-11-12T06:18:45+05:30",
         "end" => "2045-02-06T12:03:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2045-02-06T12:03:45+05:30",
         "end" => "2045-04-07T20:53:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2045-04-07T20:53:15+05:30",
         "end" => "2045-09-10T02:26:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2045-09-10T02:26:15+05:30",
         "end" => "2046-01-26T02:02:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2046-01-26T02:02:15+05:30",
         "end" => "2046-07-08T22:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2046-07-08T22:33:45+05:30",
         "end" => "2047-09-08T01:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2046-07-08T22:33:45+05:30",
         "end" => "2046-08-02T19:08:14+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2046-08-02T19:08:15+05:30",
         "end" => "2046-10-12T19:38:14+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2046-10-12T19:38:15+05:30",
         "end" => "2046-11-03T02:59:14+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2046-11-03T02:59:15+05:30",
         "end" => "2046-12-08T15:14:14+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2046-12-08T15:14:15+05:30",
         "end" => "2047-01-02T11:48:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2047-01-02T11:48:45+05:30",
         "end" => "2047-03-07T09:51:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2047-03-07T09:51:45+05:30",
         "end" => "2047-05-03T05:27:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2047-05-03T05:27:45+05:30",
         "end" => "2047-07-09T16:44:14+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2047-07-09T16:44:15+05:30",
         "end" => "2047-09-08T01:33:44+05:30"
         ]
         ]
         ]
         ]
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2047-09-08T01:33:45+05:30",
         "end" => "2053-09-07T13:33:44+05:30",
         "antardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2047-09-08T01:33:45+05:30",
         "end" => "2047-12-26T15:21:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2047-09-08T01:33:45+05:30",
         "end" => "2047-09-13T13:03:08+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2047-09-13T13:03:09+05:30",
         "end" => "2047-09-22T16:12:08+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2047-09-22T16:12:09+05:30",
         "end" => "2047-09-29T01:36:26+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2047-09-29T01:36:27+05:30",
         "end" => "2047-10-15T12:04:38+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2047-10-15T12:04:39+05:30",
         "end" => "2047-10-30T02:43:02+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2047-10-30T02:43:03+05:30",
         "end" => "2047-11-16T11:06:08+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2047-11-16T11:06:09+05:30",
         "end" => "2047-12-01T23:39:26+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2047-12-01T23:39:27+05:30",
         "end" => "2047-12-08T09:03:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2047-12-08T09:03:45+05:30",
         "end" => "2047-12-26T15:21:44+05:30"
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2047-12-26T15:21:45+05:30",
         "end" => "2048-06-26T06:21:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2047-12-26T15:21:45+05:30",
         "end" => "2048-01-10T20:36:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2048-01-10T20:36:45+05:30",
         "end" => "2048-01-21T12:17:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2048-01-21T12:17:15+05:30",
         "end" => "2048-02-17T21:44:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2048-02-17T21:44:15+05:30",
         "end" => "2048-03-13T06:08:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2048-03-13T06:08:15+05:30",
         "end" => "2048-04-11T04:06:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2048-04-11T04:06:45+05:30",
         "end" => "2048-05-07T01:02:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2048-05-07T01:02:15+05:30",
         "end" => "2048-05-17T16:42:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2048-05-17T16:42:45+05:30",
         "end" => "2048-06-17T03:12:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2048-06-17T03:12:45+05:30",
         "end" => "2048-06-26T06:21:44+05:30"
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2048-06-26T06:21:45+05:30",
         "end" => "2048-11-01T02:27:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2048-06-26T06:21:45+05:30",
         "end" => "2048-07-03T17:20:05+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2048-07-03T17:20:06+05:30",
         "end" => "2048-07-22T21:32:59+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2048-07-22T21:33:00+05:30",
         "end" => "2048-08-08T22:37:47+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2048-08-08T22:37:48+05:30",
         "end" => "2048-08-29T04:24:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2048-08-29T04:24:45+05:30",
         "end" => "2048-09-16T07:03:35+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2048-09-16T07:03:36+05:30",
         "end" => "2048-09-23T18:01:56+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2048-09-23T18:01:57+05:30",
         "end" => "2048-10-15T01:22:56+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2048-10-15T01:22:57+05:30",
         "end" => "2048-10-21T10:47:14+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2048-10-21T10:47:15+05:30",
         "end" => "2048-11-01T02:27:44+05:30"
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2048-11-01T02:27:45+05:30",
         "end" => "2049-09-25T19:51:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2048-11-01T02:27:45+05:30",
         "end" => "2048-12-20T09:52:20+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2048-12-20T09:52:21+05:30",
         "end" => "2049-02-02T05:47:32+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2049-02-02T05:47:33+05:30",
         "end" => "2049-03-26T06:56:50+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2049-03-26T06:56:51+05:30",
         "end" => "2049-05-11T20:36:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2049-05-11T20:36:45+05:30",
         "end" => "2049-05-31T00:49:38+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2049-05-31T00:49:39+05:30",
         "end" => "2049-07-24T19:43:38+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2049-07-24T19:43:39+05:30",
         "end" => "2049-08-10T06:11:50+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2049-08-10T06:11:51+05:30",
         "end" => "2049-09-06T15:38:50+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2049-09-06T15:38:51+05:30",
         "end" => "2049-09-25T19:51:44+05:30"
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2049-09-25T19:51:45+05:30",
         "end" => "2050-07-15T00:39:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2049-09-25T19:51:45+05:30",
         "end" => "2049-11-03T18:54:08+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2049-11-03T18:54:09+05:30",
         "end" => "2049-12-20T01:15:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2049-12-20T01:15:45+05:30",
         "end" => "2050-01-30T10:44:32+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2050-01-30T10:44:33+05:30",
         "end" => "2050-02-16T11:49:20+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2050-02-16T11:49:21+05:30",
         "end" => "2050-04-06T04:37:20+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2050-04-06T04:37:21+05:30",
         "end" => "2050-04-20T19:15:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2050-04-20T19:15:45+05:30",
         "end" => "2050-05-15T03:39:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2050-05-15T03:39:45+05:30",
         "end" => "2050-06-01T04:44:32+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2050-06-01T04:44:33+05:30",
         "end" => "2050-07-15T00:39:44+05:30"
         ]
         ]
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2050-07-15T00:39:45+05:30",
         "end" => "2051-06-27T00:21:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2050-07-15T00:39:45+05:30",
         "end" => "2050-09-07T23:12:53+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2050-09-07T23:12:54+05:30",
         "end" => "2050-10-27T02:58:20+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2050-10-27T02:58:21+05:30",
         "end" => "2050-11-16T08:45:17+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2050-11-16T08:45:18+05:30",
         "end" => "2051-01-13T04:42:17+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2051-01-13T04:42:18+05:30",
         "end" => "2051-01-30T13:05:23+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2051-01-30T13:05:24+05:30",
         "end" => "2051-02-28T11:03:53+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2051-02-28T11:03:54+05:30",
         "end" => "2051-03-20T16:50:50+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2051-03-20T16:50:51+05:30",
         "end" => "2051-05-11T18:00:08+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2051-05-11T18:00:09+05:30",
         "end" => "2051-06-27T00:21:44+05:30"
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2051-06-27T00:21:45+05:30",
         "end" => "2052-05-02T11:27:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2051-06-27T00:21:45+05:30",
         "end" => "2051-08-09T23:56:05+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2051-08-09T23:56:06+05:30",
         "end" => "2051-08-28T02:34:56+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2051-08-28T02:34:57+05:30",
         "end" => "2051-10-18T20:25:56+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2051-10-18T20:25:57+05:30",
         "end" => "2051-11-03T08:59:14+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2051-11-03T08:59:15+05:30",
         "end" => "2051-11-29T05:54:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2051-11-29T05:54:45+05:30",
         "end" => "2051-12-17T08:33:35+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2051-12-17T08:33:36+05:30",
         "end" => "2052-02-01T22:13:29+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2052-02-01T22:13:30+05:30",
         "end" => "2052-03-14T07:42:17+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2052-03-14T07:42:18+05:30",
         "end" => "2052-05-02T11:27:44+05:30"
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2052-05-02T11:27:45+05:30",
         "end" => "2052-09-07T07:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2052-05-02T11:27:45+05:30",
         "end" => "2052-05-09T22:26:05+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2052-05-09T22:26:06+05:30",
         "end" => "2052-05-31T05:47:05+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2052-05-31T05:47:06+05:30",
         "end" => "2052-06-06T15:11:23+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2052-06-06T15:11:24+05:30",
         "end" => "2052-06-17T06:51:53+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2052-06-17T06:51:54+05:30",
         "end" => "2052-06-24T17:50:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2052-06-24T17:50:15+05:30",
         "end" => "2052-07-13T22:03:08+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2052-07-13T22:03:09+05:30",
         "end" => "2052-07-30T23:07:56+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2052-07-30T23:07:57+05:30",
         "end" => "2052-08-20T04:54:53+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2052-08-20T04:54:54+05:30",
         "end" => "2052-09-07T07:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2052-09-07T07:33:45+05:30",
         "end" => "2053-09-07T13:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2052-09-07T07:33:45+05:30",
         "end" => "2052-11-07T04:33:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2052-11-07T04:33:45+05:30",
         "end" => "2052-11-25T10:51:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2052-11-25T10:51:45+05:30",
         "end" => "2052-12-25T21:21:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2052-12-25T21:21:45+05:30",
         "end" => "2053-01-16T04:42:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2053-01-16T04:42:45+05:30",
         "end" => "2053-03-11T23:36:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2053-03-11T23:36:45+05:30",
         "end" => "2053-04-29T16:24:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2053-04-29T16:24:45+05:30",
         "end" => "2053-06-26T12:21:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2053-06-26T12:21:45+05:30",
         "end" => "2053-08-17T06:12:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2053-08-17T06:12:45+05:30",
         "end" => "2053-09-07T13:33:44+05:30"
         ]
         ]
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2053-09-07T13:33:45+05:30",
         "end" => "2063-09-08T01:33:44+05:30",
         "antardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2053-09-07T13:33:45+05:30",
         "end" => "2054-07-08T22:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2053-09-07T13:33:45+05:30",
         "end" => "2053-10-02T22:18:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2053-10-02T22:18:45+05:30",
         "end" => "2053-10-20T16:26:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2053-10-20T16:26:15+05:30",
         "end" => "2053-12-05T08:11:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2053-12-05T08:11:15+05:30",
         "end" => "2054-01-14T22:11:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2054-01-14T22:11:15+05:30",
         "end" => "2054-03-04T02:48:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2054-03-04T02:48:45+05:30",
         "end" => "2054-04-16T05:41:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2054-04-16T05:41:15+05:30",
         "end" => "2054-05-03T23:48:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2054-05-03T23:48:45+05:30",
         "end" => "2054-06-23T17:18:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2054-06-23T17:18:45+05:30",
         "end" => "2054-07-08T22:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2054-07-08T22:33:45+05:30",
         "end" => "2055-02-07T00:03:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2054-07-08T22:33:45+05:30",
         "end" => "2054-07-21T08:50:59+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2054-07-21T08:51:00+05:30",
         "end" => "2054-08-22T07:52:29+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2054-08-22T07:52:30+05:30",
         "end" => "2054-09-19T17:40:29+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2054-09-19T17:40:30+05:30",
         "end" => "2054-10-23T11:18:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2054-10-23T11:18:45+05:30",
         "end" => "2054-11-22T15:43:29+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2054-11-22T15:43:30+05:30",
         "end" => "2054-12-05T02:00:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2054-12-05T02:00:45+05:30",
         "end" => "2055-01-09T14:15:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2055-01-09T14:15:45+05:30",
         "end" => "2055-01-20T05:56:14+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2055-01-20T05:56:15+05:30",
         "end" => "2055-02-07T00:03:44+05:30"
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2055-02-07T00:03:45+05:30",
         "end" => "2056-08-07T21:03:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2055-02-07T00:03:45+05:30",
         "end" => "2055-04-30T04:24:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2055-04-30T04:24:45+05:30",
         "end" => "2055-07-12T05:36:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2055-07-12T05:36:45+05:30",
         "end" => "2055-10-06T23:32:14+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2055-10-06T23:32:15+05:30",
         "end" => "2055-12-23T14:18:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2055-12-23T14:18:45+05:30",
         "end" => "2056-01-24T13:20:14+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2056-01-24T13:20:15+05:30",
         "end" => "2056-04-24T20:50:14+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2056-04-24T20:50:15+05:30",
         "end" => "2056-05-22T06:17:14+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2056-05-22T06:17:15+05:30",
         "end" => "2056-07-06T22:02:14+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2056-07-06T22:02:15+05:30",
         "end" => "2056-08-07T21:03:44+05:30"
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2056-08-07T21:03:45+05:30",
         "end" => "2057-12-07T21:03:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2056-08-07T21:03:45+05:30",
         "end" => "2056-10-11T19:27:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2056-10-11T19:27:45+05:30",
         "end" => "2056-12-27T22:03:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2056-12-27T22:03:45+05:30",
         "end" => "2057-03-06T21:51:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2057-03-06T21:51:45+05:30",
         "end" => "2057-04-04T07:39:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2057-04-04T07:39:45+05:30",
         "end" => "2057-06-24T11:39:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2057-06-24T11:39:45+05:30",
         "end" => "2057-07-18T20:03:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2057-07-18T20:03:45+05:30",
         "end" => "2057-08-28T10:03:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2057-08-28T10:03:45+05:30",
         "end" => "2057-09-25T19:51:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2057-09-25T19:51:45+05:30",
         "end" => "2057-12-07T21:03:44+05:30"
         ]
         ]
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2057-12-07T21:03:45+05:30",
         "end" => "2059-07-09T04:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2057-12-07T21:03:45+05:30",
         "end" => "2058-03-09T10:38:59+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2058-03-09T10:39:00+05:30",
         "end" => "2058-05-30T08:54:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2058-05-30T08:54:45+05:30",
         "end" => "2058-07-03T02:32:59+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2058-07-03T02:33:00+05:30",
         "end" => "2058-10-07T11:47:59+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2058-10-07T11:48:00+05:30",
         "end" => "2058-11-05T09:46:29+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2058-11-05T09:46:30+05:30",
         "end" => "2058-12-23T14:23:59+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2058-12-23T14:24:00+05:30",
         "end" => "2059-01-26T08:02:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2059-01-26T08:02:15+05:30",
         "end" => "2059-04-23T01:57:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2059-04-23T01:57:45+05:30",
         "end" => "2059-07-09T04:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2059-07-09T04:33:45+05:30",
         "end" => "2060-12-07T15:03:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2059-07-09T04:33:45+05:30",
         "end" => "2059-09-20T11:50:59+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2059-09-20T11:51:00+05:30",
         "end" => "2059-10-20T16:15:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2059-10-20T16:15:45+05:30",
         "end" => "2060-01-14T22:00:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2060-01-14T22:00:45+05:30",
         "end" => "2060-02-09T18:56:14+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2060-02-09T18:56:15+05:30",
         "end" => "2060-03-23T21:48:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2060-03-23T21:48:45+05:30",
         "end" => "2060-04-23T02:13:29+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2060-04-23T02:13:30+05:30",
         "end" => "2060-07-09T16:59:59+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2060-07-09T17:00:00+05:30",
         "end" => "2060-09-16T16:47:59+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2060-09-16T16:48:00+05:30",
         "end" => "2060-12-07T15:03:44+05:30"
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2060-12-07T15:03:45+05:30",
         "end" => "2061-07-08T16:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2060-12-07T15:03:45+05:30",
         "end" => "2060-12-20T01:20:59+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2060-12-20T01:21:00+05:30",
         "end" => "2061-01-24T13:35:59+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2061-01-24T13:36:00+05:30",
         "end" => "2061-02-04T05:16:29+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2061-02-04T05:16:30+05:30",
         "end" => "2061-02-21T23:23:59+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2061-02-21T23:24:00+05:30",
         "end" => "2061-03-06T09:41:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2061-03-06T09:41:15+05:30",
         "end" => "2061-04-07T08:42:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2061-04-07T08:42:45+05:30",
         "end" => "2061-05-05T18:30:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2061-05-05T18:30:45+05:30",
         "end" => "2061-06-08T12:08:59+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2061-06-08T12:09:00+05:30",
         "end" => "2061-07-08T16:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2061-07-08T16:33:45+05:30",
         "end" => "2063-03-09T10:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2061-07-08T16:33:45+05:30",
         "end" => "2061-10-18T03:33:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2061-10-18T03:33:45+05:30",
         "end" => "2061-11-17T14:03:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2061-11-17T14:03:45+05:30",
         "end" => "2062-01-07T07:33:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2062-01-07T07:33:45+05:30",
         "end" => "2062-02-11T19:48:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2062-02-11T19:48:45+05:30",
         "end" => "2062-05-14T03:18:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2062-05-14T03:18:45+05:30",
         "end" => "2062-08-03T07:18:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2062-08-03T07:18:45+05:30",
         "end" => "2062-11-07T16:33:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2062-11-07T16:33:45+05:30",
         "end" => "2063-02-01T22:18:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2063-02-01T22:18:45+05:30",
         "end" => "2063-03-09T10:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2063-03-09T10:33:45+05:30",
         "end" => "2063-09-08T01:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2063-03-09T10:33:45+05:30",
         "end" => "2063-03-18T13:42:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2063-03-18T13:42:45+05:30",
         "end" => "2063-04-02T18:57:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2063-04-02T18:57:45+05:30",
         "end" => "2063-04-13T10:38:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2063-04-13T10:38:15+05:30",
         "end" => "2063-05-10T20:05:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2063-05-10T20:05:15+05:30",
         "end" => "2063-06-04T04:29:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2063-06-04T04:29:15+05:30",
         "end" => "2063-07-03T02:27:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2063-07-03T02:27:45+05:30",
         "end" => "2063-07-28T23:23:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2063-07-28T23:23:15+05:30",
         "end" => "2063-08-08T15:03:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2063-08-08T15:03:45+05:30",
         "end" => "2063-09-08T01:33:44+05:30"
         ]
         ]
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2063-09-08T01:33:45+05:30",
         "end" => "2070-09-07T19:33:44+05:30",
         "antardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2063-09-08T01:33:45+05:30",
         "end" => "2064-02-04T05:00:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2063-09-08T01:33:45+05:30",
         "end" => "2063-09-16T18:21:48+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2063-09-16T18:21:49+05:30",
         "end" => "2063-10-09T03:16:51+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2063-10-09T03:16:52+05:30",
         "end" => "2063-10-29T00:32:27+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2063-10-29T00:32:28+05:30",
         "end" => "2063-11-21T15:17:13+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2063-11-21T15:17:14+05:30",
         "end" => "2063-12-12T18:22:32+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2063-12-12T18:22:33+05:30",
         "end" => "2063-12-21T11:10:36+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2063-12-21T11:10:37+05:30",
         "end" => "2064-01-15T07:45:06+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2064-01-15T07:45:07+05:30",
         "end" => "2064-01-22T18:43:27+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2064-01-22T18:43:28+05:30",
         "end" => "2064-02-04T05:00:42+05:30"
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2064-02-04T05:00:45+05:30",
         "end" => "2065-02-21T17:18:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2064-02-04T05:00:45+05:30",
         "end" => "2064-04-01T17:39:26+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2064-04-01T17:39:27+05:30",
         "end" => "2064-05-22T20:53:50+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2064-05-22T20:53:51+05:30",
         "end" => "2064-07-22T14:14:41+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2064-07-22T14:14:42+05:30",
         "end" => "2064-09-14T22:11:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2064-09-14T22:11:15+05:30",
         "end" => "2064-10-07T07:06:17+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2064-10-07T07:06:18+05:30",
         "end" => "2064-12-10T05:09:17+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2064-12-10T05:09:18+05:30",
         "end" => "2064-12-29T09:22:11+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2064-12-29T09:22:12+05:30",
         "end" => "2065-01-30T08:23:41+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2065-01-30T08:23:42+05:30",
         "end" => "2065-02-21T17:18:44+05:30"
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2065-02-21T17:18:45+05:30",
         "end" => "2066-01-28T14:54:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2065-02-21T17:18:45+05:30",
         "end" => "2065-04-08T04:11:32+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2065-04-08T04:11:33+05:30",
         "end" => "2065-06-01T03:36:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2065-06-01T03:36:45+05:30",
         "end" => "2065-07-19T10:40:20+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2065-07-19T10:40:21+05:30",
         "end" => "2065-08-08T07:55:56+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2065-08-08T07:55:57+05:30",
         "end" => "2065-10-04T03:31:56+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2065-10-04T03:31:57+05:30",
         "end" => "2065-10-21T04:36:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2065-10-21T04:36:45+05:30",
         "end" => "2065-11-18T14:24:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2065-11-18T14:24:45+05:30",
         "end" => "2065-12-08T11:40:20+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2065-12-08T11:40:21+05:30",
         "end" => "2066-01-28T14:54:44+05:30"
         ]
         ]
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2066-01-28T14:54:45+05:30",
         "end" => "2067-03-09T10:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2066-01-28T14:54:45+05:30",
         "end" => "2066-04-02T17:13:24+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2066-04-02T17:13:25+05:30",
         "end" => "2066-05-30T01:36:25+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2066-05-30T01:36:26+05:30",
         "end" => "2066-06-22T16:21:11+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2066-06-22T16:21:12+05:30",
         "end" => "2066-08-29T03:37:41+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2066-08-29T03:37:42+05:30",
         "end" => "2066-09-18T09:24:38+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2066-09-18T09:24:39+05:30",
         "end" => "2066-10-22T03:02:53+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2066-10-22T03:02:54+05:30",
         "end" => "2066-11-14T17:47:39+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2066-11-14T17:47:40+05:30",
         "end" => "2067-01-14T11:08:30+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2067-01-14T11:08:31+05:30",
         "end" => "2067-03-09T10:33:42+05:30"
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2067-03-09T10:33:45+05:30",
         "end" => "2068-03-05T15:30:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2067-03-09T10:33:45+05:30",
         "end" => "2067-04-29T18:03:48+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2067-04-29T18:03:49+05:30",
         "end" => "2067-05-20T21:09:07+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2067-05-20T21:09:08+05:30",
         "end" => "2067-07-20T05:58:37+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2067-07-20T05:58:38+05:30",
         "end" => "2067-08-07T08:37:28+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2067-08-07T08:37:29+05:30",
         "end" => "2067-09-06T13:02:13+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2067-09-06T13:02:14+05:30",
         "end" => "2067-09-27T16:07:32+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2067-09-27T16:07:33+05:30",
         "end" => "2067-11-21T00:04:05+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2067-11-21T00:04:06+05:30",
         "end" => "2068-01-08T07:07:41+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2068-01-08T07:07:42+05:30",
         "end" => "2068-03-05T15:30:42+05:30"
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2068-03-05T15:30:45+05:30",
         "end" => "2068-08-01T18:57:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2068-03-05T15:30:45+05:30",
         "end" => "2068-03-14T08:18:48+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2068-03-14T08:18:49+05:30",
         "end" => "2068-04-08T04:53:18+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2068-04-08T04:53:19+05:30",
         "end" => "2068-04-15T15:51:39+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2068-04-15T15:51:40+05:30",
         "end" => "2068-04-28T02:08:54+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2068-04-28T02:08:55+05:30",
         "end" => "2068-05-06T18:56:58+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2068-05-06T18:56:59+05:30",
         "end" => "2068-05-29T03:52:01+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2068-05-29T03:52:02+05:30",
         "end" => "2068-06-18T01:07:37+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2068-06-18T01:07:38+05:30",
         "end" => "2068-07-11T15:52:23+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2068-07-11T15:52:24+05:30",
         "end" => "2068-08-01T18:57:42+05:30"
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2068-08-01T18:57:45+05:30",
         "end" => "2069-10-01T21:57:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2068-08-01T18:57:45+05:30",
         "end" => "2068-10-11T19:27:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2068-10-11T19:27:45+05:30",
         "end" => "2068-11-02T02:48:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2068-11-02T02:48:45+05:30",
         "end" => "2068-12-07T15:03:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2068-12-07T15:03:45+05:30",
         "end" => "2069-01-01T11:38:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2069-01-01T11:38:15+05:30",
         "end" => "2069-03-06T09:41:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2069-03-06T09:41:15+05:30",
         "end" => "2069-05-02T05:17:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2069-05-02T05:17:15+05:30",
         "end" => "2069-07-08T16:33:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2069-07-08T16:33:45+05:30",
         "end" => "2069-09-07T01:23:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2069-09-07T01:23:15+05:30",
         "end" => "2069-10-01T21:57:44+05:30"
         ]
         ]
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2069-10-01T21:57:45+05:30",
         "end" => "2070-02-06T18:03:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2069-10-01T21:57:45+05:30",
         "end" => "2069-10-08T07:22:02+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2069-10-08T07:22:03+05:30",
         "end" => "2069-10-18T23:02:32+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2069-10-18T23:02:33+05:30",
         "end" => "2069-10-26T10:00:53+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2069-10-26T10:00:54+05:30",
         "end" => "2069-11-14T14:13:47+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2069-11-14T14:13:48+05:30",
         "end" => "2069-12-01T15:18:35+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2069-12-01T15:18:36+05:30",
         "end" => "2069-12-21T21:05:32+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2069-12-21T21:05:33+05:30",
         "end" => "2070-01-08T23:44:23+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2070-01-08T23:44:24+05:30",
         "end" => "2070-01-16T10:42:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2070-01-16T10:42:45+05:30",
         "end" => "2070-02-06T18:03:44+05:30"
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2070-02-06T18:03:45+05:30",
         "end" => "2070-09-07T19:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2070-02-06T18:03:45+05:30",
         "end" => "2070-02-24T12:11:14+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2070-02-24T12:11:15+05:30",
         "end" => "2070-03-08T22:28:29+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2070-03-08T22:28:30+05:30",
         "end" => "2070-04-09T21:29:59+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2070-04-09T21:30:00+05:30",
         "end" => "2070-05-08T07:17:59+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2070-05-08T07:18:00+05:30",
         "end" => "2070-06-11T00:56:14+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2070-06-11T00:56:15+05:30",
         "end" => "2070-07-11T05:20:59+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2070-07-11T05:21:00+05:30",
         "end" => "2070-07-23T15:38:14+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2070-07-23T15:38:15+05:30",
         "end" => "2070-08-28T03:53:14+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2070-08-28T03:53:15+05:30",
         "end" => "2070-09-07T19:33:44+05:30"
         ]
         ]
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2070-09-07T19:33:45+05:30",
         "end" => "2088-09-07T07:33:44+05:30",
         "antardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2070-09-07T19:33:45+05:30",
         "end" => "2073-05-20T23:45:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2070-09-07T19:33:45+05:30",
         "end" => "2071-02-02T17:47:32+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2071-02-02T17:47:33+05:30",
         "end" => "2071-06-14T05:33:08+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2071-06-14T05:33:09+05:30",
         "end" => "2071-11-17T09:01:02+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2071-11-17T09:01:03+05:30",
         "end" => "2072-04-05T02:00:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2072-04-05T02:00:45+05:30",
         "end" => "2072-06-01T14:39:26+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2072-06-01T14:39:27+05:30",
         "end" => "2072-11-12T23:21:26+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2072-11-12T23:21:27+05:30",
         "end" => "2073-01-01T06:46:02+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2073-01-01T06:46:03+05:30",
         "end" => "2073-03-24T11:07:02+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2073-03-24T11:07:03+05:30",
         "end" => "2073-05-20T23:45:44+05:30"
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2073-05-20T23:45:45+05:30",
         "end" => "2075-10-14T14:09:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2073-05-20T23:45:45+05:30",
         "end" => "2073-09-14T20:52:56+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2073-09-14T20:52:57+05:30",
         "end" => "2074-01-31T15:57:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2074-01-31T15:57:45+05:30",
         "end" => "2074-06-04T20:24:08+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2074-06-04T20:24:09+05:30",
         "end" => "2074-07-25T23:38:32+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2074-07-25T23:38:33+05:30",
         "end" => "2074-12-19T02:02:32+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2074-12-19T02:02:33+05:30",
         "end" => "2075-01-31T21:57:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2075-01-31T21:57:45+05:30",
         "end" => "2075-04-14T23:09:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2075-04-14T23:09:45+05:30",
         "end" => "2075-06-05T02:24:08+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2075-06-05T02:24:09+05:30",
         "end" => "2075-10-14T14:09:44+05:30"
         ]
         ]
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2075-10-14T14:09:45+05:30",
         "end" => "2078-08-20T13:15:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2075-10-14T14:09:45+05:30",
         "end" => "2076-03-27T09:49:11+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2076-03-27T09:49:12+05:30",
         "end" => "2076-08-21T21:05:32+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2076-08-21T21:05:33+05:30",
         "end" => "2076-10-21T14:26:23+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2076-10-21T14:26:24+05:30",
         "end" => "2077-04-13T02:17:23+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2077-04-13T02:17:24+05:30",
         "end" => "2077-06-04T03:26:41+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2077-06-04T03:26:42+05:30",
         "end" => "2077-08-29T21:22:11+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2077-08-29T21:22:12+05:30",
         "end" => "2077-10-29T14:43:02+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2077-10-29T14:43:03+05:30",
         "end" => "2078-04-03T18:10:56+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2078-04-03T18:10:57+05:30",
         "end" => "2078-08-20T13:15:44+05:30"
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2078-08-20T13:15:45+05:30",
         "end" => "2081-03-08T22:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2078-08-20T13:15:45+05:30",
         "end" => "2078-12-30T11:58:47+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2078-12-30T11:58:48+05:30",
         "end" => "2079-02-22T19:55:20+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2079-02-22T19:55:21+05:30",
         "end" => "2079-07-28T01:28:20+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2079-07-28T01:28:21+05:30",
         "end" => "2079-09-12T15:08:14+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2079-09-12T15:08:15+05:30",
         "end" => "2079-11-29T05:54:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2079-11-29T05:54:45+05:30",
         "end" => "2080-01-22T13:51:17+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2080-01-22T13:51:18+05:30",
         "end" => "2080-06-10T06:50:59+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2080-06-10T06:51:00+05:30",
         "end" => "2080-10-12T11:17:23+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2080-10-12T11:17:24+05:30",
         "end" => "2081-03-08T22:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2081-03-08T22:33:45+05:30",
         "end" => "2082-03-27T10:51:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2081-03-08T22:33:45+05:30",
         "end" => "2081-03-31T07:28:47+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2081-03-31T07:28:48+05:30",
         "end" => "2081-06-03T05:31:47+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2081-06-03T05:31:48+05:30",
         "end" => "2081-06-22T09:44:41+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2081-06-22T09:44:42+05:30",
         "end" => "2081-07-24T08:46:11+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2081-07-24T08:46:12+05:30",
         "end" => "2081-08-15T17:41:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2081-08-15T17:41:15+05:30",
         "end" => "2081-10-12T06:19:56+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2081-10-12T06:19:57+05:30",
         "end" => "2081-12-02T09:34:20+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2081-12-02T09:34:21+05:30",
         "end" => "2082-02-01T02:55:11+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2082-02-01T02:55:12+05:30",
         "end" => "2082-03-27T10:51:44+05:30"
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2082-03-27T10:51:45+05:30",
         "end" => "2085-03-27T04:51:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2082-03-27T10:51:45+05:30",
         "end" => "2082-09-26T01:51:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2082-09-26T01:51:45+05:30",
         "end" => "2082-11-19T20:45:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2082-11-19T20:45:45+05:30",
         "end" => "2083-02-19T04:15:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2083-02-19T04:15:45+05:30",
         "end" => "2083-04-24T02:18:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2083-04-24T02:18:45+05:30",
         "end" => "2083-10-05T11:00:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2083-10-05T11:00:45+05:30",
         "end" => "2084-02-28T13:24:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2084-02-28T13:24:45+05:30",
         "end" => "2084-08-20T01:15:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2084-08-20T01:15:45+05:30",
         "end" => "2085-01-22T06:48:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2085-01-22T06:48:45+05:30",
         "end" => "2085-03-27T04:51:44+05:30"
         ]
         ]
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2085-03-27T04:51:45+05:30",
         "end" => "2086-02-18T22:15:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2085-03-27T04:51:45+05:30",
         "end" => "2085-04-12T15:19:56+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2085-04-12T15:19:57+05:30",
         "end" => "2085-05-10T00:46:56+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2085-05-10T00:46:57+05:30",
         "end" => "2085-05-29T04:59:50+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2085-05-29T04:59:51+05:30",
         "end" => "2085-07-17T12:24:26+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2085-07-17T12:24:27+05:30",
         "end" => "2085-08-30T08:19:38+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2085-08-30T08:19:39+05:30",
         "end" => "2085-10-21T09:28:56+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2085-10-21T09:28:57+05:30",
         "end" => "2085-12-06T23:08:50+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2085-12-06T23:08:51+05:30",
         "end" => "2085-12-26T03:21:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2085-12-26T03:21:45+05:30",
         "end" => "2086-02-18T22:15:44+05:30"
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2086-02-18T22:15:45+05:30",
         "end" => "2087-08-20T19:15:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2086-02-18T22:15:45+05:30",
         "end" => "2086-04-05T14:00:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2086-04-05T14:00:45+05:30",
         "end" => "2086-05-07T13:02:14+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2086-05-07T13:02:15+05:30",
         "end" => "2086-07-28T17:23:14+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2086-07-28T17:23:15+05:30",
         "end" => "2086-10-09T18:35:14+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2086-10-09T18:35:15+05:30",
         "end" => "2087-01-04T12:30:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2087-01-04T12:30:45+05:30",
         "end" => "2087-03-23T03:17:14+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2087-03-23T03:17:15+05:30",
         "end" => "2087-04-24T02:18:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2087-04-24T02:18:45+05:30",
         "end" => "2087-07-24T09:48:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2087-07-24T09:48:45+05:30",
         "end" => "2087-08-20T19:15:44+05:30"
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2087-08-20T19:15:45+05:30",
         "end" => "2088-09-07T07:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2087-08-20T19:15:45+05:30",
         "end" => "2087-09-12T04:10:47+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2087-09-12T04:10:48+05:30",
         "end" => "2087-11-08T16:49:29+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2087-11-08T16:49:30+05:30",
         "end" => "2087-12-29T20:03:53+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2087-12-29T20:03:54+05:30",
         "end" => "2088-02-28T13:24:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2088-02-28T13:24:45+05:30",
         "end" => "2088-04-22T21:21:17+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2088-04-22T21:21:18+05:30",
         "end" => "2088-05-15T06:16:20+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2088-05-15T06:16:21+05:30",
         "end" => "2088-07-18T04:19:20+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2088-07-18T04:19:21+05:30",
         "end" => "2088-08-06T08:32:14+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2088-08-06T08:32:15+05:30",
         "end" => "2088-09-07T07:33:44+05:30"
         ]
         ]
         ]
         ]
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2088-09-07T07:33:45+05:30",
         "end" => "2104-09-08T07:33:44+05:30",
         "antardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2088-09-07T07:33:45+05:30",
         "end" => "2090-10-26T12:21:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2088-09-07T07:33:45+05:30",
         "end" => "2088-12-20T05:00:08+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2088-12-20T05:00:09+05:30",
         "end" => "2089-04-22T13:57:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2089-04-22T13:57:45+05:30",
         "end" => "2089-08-10T23:14:32+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2089-08-10T23:14:33+05:30",
         "end" => "2089-09-25T10:07:20+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2089-09-25T10:07:21+05:30",
         "end" => "2090-02-02T06:55:20+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2090-02-02T06:55:21+05:30",
         "end" => "2090-03-13T05:57:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2090-03-13T05:57:45+05:30",
         "end" => "2090-05-17T04:21:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2090-05-17T04:21:45+05:30",
         "end" => "2090-07-01T15:14:32+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2090-07-01T15:14:33+05:30",
         "end" => "2090-10-26T12:21:44+05:30"
         ]
         ]
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2090-10-26T12:21:45+05:30",
         "end" => "2093-05-08T19:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2090-10-26T12:21:45+05:30",
         "end" => "2091-03-22T00:30:08+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2091-03-22T00:30:09+05:30",
         "end" => "2091-07-31T02:31:20+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2091-07-31T02:31:21+05:30",
         "end" => "2091-09-23T01:56:32+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2091-09-23T01:56:33+05:30",
         "end" => "2092-02-24T07:08:32+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2092-02-24T07:08:33+05:30",
         "end" => "2092-04-10T13:30:08+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2092-04-10T13:30:09+05:30",
         "end" => "2092-06-26T16:06:08+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2092-06-26T16:06:09+05:30",
         "end" => "2092-08-19T15:31:20+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2092-08-19T15:31:21+05:30",
         "end" => "2093-01-05T10:36:08+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2093-01-05T10:36:09+05:30",
         "end" => "2093-05-08T19:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2093-05-08T19:33:45+05:30",
         "end" => "2095-08-14T17:09:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2093-05-08T19:33:45+05:30",
         "end" => "2093-09-03T02:25:20+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2093-09-03T02:25:21+05:30",
         "end" => "2093-10-21T09:28:56+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2093-10-21T09:28:57+05:30",
         "end" => "2094-03-08T09:04:56+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2094-03-08T09:04:57+05:30",
         "end" => "2094-04-18T18:33:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2094-04-18T18:33:45+05:30",
         "end" => "2094-06-26T18:21:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2094-06-26T18:21:45+05:30",
         "end" => "2094-08-14T01:25:20+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2094-08-14T01:25:21+05:30",
         "end" => "2094-12-16T05:51:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2094-12-16T05:51:45+05:30",
         "end" => "2095-04-05T15:08:32+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2095-04-05T15:08:33+05:30",
         "end" => "2095-08-14T17:09:44+05:30"
         ]
         ]
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2095-08-14T17:09:45+05:30",
         "end" => "2096-07-20T14:45:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2095-08-14T17:09:45+05:30",
         "end" => "2095-09-03T14:25:20+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2095-09-03T14:25:21+05:30",
         "end" => "2095-10-30T10:01:20+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2095-10-30T10:01:21+05:30",
         "end" => "2095-11-16T11:06:08+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2095-11-16T11:06:09+05:30",
         "end" => "2095-12-14T20:54:08+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2095-12-14T20:54:09+05:30",
         "end" => "2096-01-03T18:09:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2096-01-03T18:09:45+05:30",
         "end" => "2096-02-23T21:24:08+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2096-02-23T21:24:09+05:30",
         "end" => "2096-04-09T08:16:56+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2096-04-09T08:16:57+05:30",
         "end" => "2096-06-02T07:42:08+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2096-06-02T07:42:09+05:30",
         "end" => "2096-07-20T14:45:44+05:30"
         ]
         ]
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2096-07-20T14:45:45+05:30",
         "end" => "2099-03-21T14:45:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2096-07-20T14:45:45+05:30",
         "end" => "2096-12-29T22:45:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2096-12-29T22:45:45+05:30",
         "end" => "2097-02-16T15:33:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2097-02-16T15:33:45+05:30",
         "end" => "2097-05-08T19:33:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2097-05-08T19:33:45+05:30",
         "end" => "2097-07-04T15:09:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2097-07-04T15:09:45+05:30",
         "end" => "2097-11-27T17:33:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2097-11-27T17:33:45+05:30",
         "end" => "2098-04-06T14:21:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2098-04-06T14:21:45+05:30",
         "end" => "2098-09-07T19:33:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2098-09-07T19:33:45+05:30",
         "end" => "2099-01-23T19:09:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2099-01-23T19:09:45+05:30",
         "end" => "2099-03-21T14:45:44+05:30"
         ]
         ]
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2099-03-21T14:45:45+05:30",
         "end" => "2100-01-07T19:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2099-03-21T14:45:45+05:30",
         "end" => "2099-04-05T05:24:08+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2099-04-05T05:24:09+05:30",
         "end" => "2099-04-29T13:48:08+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2099-04-29T13:48:09+05:30",
         "end" => "2099-05-16T14:52:56+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2099-05-16T14:52:57+05:30",
         "end" => "2099-06-29T10:48:08+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2099-06-29T10:48:09+05:30",
         "end" => "2099-08-07T09:50:32+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2099-08-07T09:50:33+05:30",
         "end" => "2099-09-22T16:12:08+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2099-09-22T16:12:09+05:30",
         "end" => "2099-11-03T01:40:56+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2099-11-03T01:40:57+05:30",
         "end" => "2099-11-20T02:45:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2099-11-20T02:45:45+05:30",
         "end" => "2100-01-07T19:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2100-01-07T19:33:45+05:30",
         "end" => "2101-05-09T19:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2100-01-07T19:33:45+05:30",
         "end" => "2100-02-17T09:33:44+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2100-02-17T09:33:45+05:30",
         "end" => "2100-03-17T19:21:44+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2100-03-17T19:21:45+05:30",
         "end" => "2100-05-29T20:33:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2100-05-29T20:33:45+05:30",
         "end" => "2100-08-02T18:57:44+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2100-08-02T18:57:45+05:30",
         "end" => "2100-10-18T21:33:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2100-10-18T21:33:45+05:30",
         "end" => "2100-12-26T21:21:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2100-12-26T21:21:45+05:30",
         "end" => "2101-01-24T07:09:44+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2101-01-24T07:09:45+05:30",
         "end" => "2101-04-15T11:09:44+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2101-04-15T11:09:45+05:30",
         "end" => "2101-05-09T19:33:44+05:30"
         ]
         ]
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2101-05-09T19:33:45+05:30",
         "end" => "2102-04-15T17:09:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2101-05-09T19:33:45+05:30",
         "end" => "2101-05-29T16:49:20+05:30"
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2101-05-29T16:49:21+05:30",
         "end" => "2101-07-19T20:03:44+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2101-07-19T20:03:45+05:30",
         "end" => "2101-09-03T06:56:32+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2101-09-03T06:56:33+05:30",
         "end" => "2101-10-27T06:21:44+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2101-10-27T06:21:45+05:30",
         "end" => "2101-12-14T13:25:20+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2101-12-14T13:25:21+05:30",
         "end" => "2102-01-03T10:40:56+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2102-01-03T10:40:57+05:30",
         "end" => "2102-03-01T06:16:56+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2102-03-01T06:16:57+05:30",
         "end" => "2102-03-18T07:21:44+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2102-03-18T07:21:45+05:30",
         "end" => "2102-04-15T17:09:44+05:30"
         ]
         ]
         ],
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2102-04-15T17:09:45+05:30",
         "end" => "2104-09-08T07:33:44+05:30",
         "pratyantardasha" => [
         [
         "id" => 101,
         "name" => "राहु",
         "start" => "2102-04-15T17:09:45+05:30",
         "end" => "2102-08-25T04:55:20+05:30"
         ],
         [
         "id" => 5,
         "name" => "गुरू",
         "start" => "2102-08-25T04:55:21+05:30",
         "end" => "2102-12-20T02:02:32+05:30"
         ],
         [
         "id" => 6,
         "name" => "शनि",
         "start" => "2102-12-20T02:02:33+05:30",
         "end" => "2103-05-07T21:07:20+05:30"
         ],
         [
         "id" => 2,
         "name" => "बुध",
         "start" => "2103-05-07T21:07:21+05:30",
         "end" => "2103-09-09T01:33:44+05:30"
         ],
         [
         "id" => 102,
         "name" => "केतु",
         "start" => "2103-09-09T01:33:45+05:30",
         "end" => "2103-10-30T04:48:08+05:30"
         ],
         [
         "id" => 3,
         "name" => "शुक्र",
         "start" => "2103-10-30T04:48:09+05:30",
         "end" => "2104-03-24T07:12:08+05:30"
         ],
         [
         "id" => 0,
         "name" => "सूर्य",
         "start" => "2104-03-24T07:12:09+05:30",
         "end" => "2104-05-07T03:07:20+05:30"
         ],
         [
         "id" => 1,
         "name" => "चंद्र",
         "start" => "2104-05-07T03:07:21+05:30",
         "end" => "2104-07-19T04:19:20+05:30"
         ],
         [
         "id" => 4,
         "name" => "मंगल",
         "start" => "2104-07-19T04:19:21+05:30",
         "end" => "2104-09-08T07:33:44+05:30"
         ]
         ]
         ]
         ]
         ]
         ],
         "dasha_balance" => [
         "lord" => [
         "id" => 6,
         "name" => "शनि",
         "vedic_name" => "शनि"
         ],
         "duration" => "P15Y10M13DT20H10M44S",
         "description" => "15 वर्ष 10 महीने 13 दिवस"
         ]
         ]
         ];
      $details = $details['data'];
      // Start output buffer
      ob_start();

      // 1. Nakshatra Details
      echo "<h2>नक्षत्र जानकारी</h2>";
      $nakshatra = $details['nakshatra_details']['nakshatra'];
      echo "नक्षत्र: {$nakshatra['name']}<br>";
      echo "पद: {$nakshatra['pada']}<br>";
      echo "स्वामी: {$nakshatra['lord']['name']} ({$nakshatra['lord']['vedic_name']})<br>";

      // 2. Mangal Dosha
      echo "<h2>मंगल दोष</h2>";
      $mangal = $details['mangal_dosha'];
      echo "मंगल दोष है: " . ($mangal['has_dosha'] ? "हाँ" : "नहीं") . "<br>";
      echo "विवरण: {$mangal['description']}<br>";
      echo "दोष प्रकार: {$mangal['type']}<br>";

      // 3. Yoga Details
      echo "<h2>योग विवरण</h2>";
      foreach ($details['yoga_details'] as $yoga) {
          echo "<h3>".$yoga['name']."</h3>";
          echo "<p>".$yoga['description']."</p>";
          if (!empty($yoga['yoga_list'])) {
              echo "<ul>";
              foreach ($yoga['yoga_list'] as $item) {
                  echo "<li>Name ".$item['name']."</li>"; 
                  echo "<li>is available ".$item['has_yoga']."</li>"; 
                  echo "<li>description ".$item['name']."</li>"; 
                  echo '<br>';
              }
              echo "</ul>";
          }
      }

      // 4. Dasha Periods
      echo "<h2>दशा विवरण</h2>";
      foreach ($details['dasha_periods'] as $dasha) {
          echo "<strong>".$dasha['name']."</strong>: ".$dasha['start']." से ".$dasha['end']."<br>";
      }

      // 5. Dasha Balance
      echo "<h2>दशा बैलेंस</h2>";
      $dashaBalance = $details['dasha_balance'];
      echo "स्वामी: ".$dashaBalance['lord']['name']."<br>";
      echo "अवधि: ".$dashaBalance['description']."<br>";

      echo '<br><b>Planet chart<b>';
      echo "<table border='1' cellpadding='5' cellspacing='0'>";
      echo "<tr>
            <th>ग्रह</th>
            <th>राशि</th>
            <th>अंश (डिग्री)</th>
            <th>स्थिति (स्थान)</th>
            <th>वक्री</th>
            <th>राशि स्वामी</th>
            </tr>";

            
      foreach ($planet_details["data"]["planet_position"] as $planet) {
         echo "<tr>";
         echo "<td>" . $planet["name"] . "</td>";
         echo "<td>" . $planet["rasi"]["name"] . "</td>";
         echo "<td>" . round($planet["degree"], 2) . "</td>";
         echo "<td>" . $planet["position"] . "</td>";
         echo "<td>" . ($planet["is_retrograde"] ? "हाँ" : "नहीं") . "</td>";
         echo "<td>" . $planet["rasi"]["lord"]["name"] . "</td>";
         echo "</tr>";
      }

      // Get output
      $output = ob_get_clean();
      echo $output;
    }
    
}
