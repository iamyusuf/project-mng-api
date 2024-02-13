<?php

namespace App\Http\Controllers;

use App\Classes\Registry;
use App\Enums\Gender;
use App\Enums\Suit;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Throwable;


class HomeController extends Controller
{
    public function index()
    {
        $enumValue = 'C';
        $data =  [
            'frameworkVersion' => app()->version(),
            'spades' => $this->pickACard(Suit::Spades),
            'diamonds' => $this->pickACardValue(Suit::Diamonds),
            'clubs' => $this->pickACardValue(Suit::from('C')),
            'color' => Suit::Clubs->color(),
            'suits' => Suit::values(),
            'suitsKeyVal' => array_flip(Suit::forSelect()),
            'kjsfk' => Suit::forSelect2(),
            'genders' => Gender::forSelect()
        ];

        return response()->json($data);
        return view('home', $data);
    }

    public function matches(Request $request)
    {
        $status = (string) $request->get('status');



        return match($status) {
            '200' => response()->json(['success' => true, 'message' => 'Success'], $status),
            '201' => response()->json('Successfully Created', $status),
            '404' => response()->json('Not Found', $status),
            default => response()->json('something went wrong')
        };
    }


    /**
     * @throws Throwable
     */
    public function fiber(Request $request)
    {
        echo "fiber not started yet\n";

        $fiber = new \Fiber(function (): void {
            $value = \Fiber::suspend('suspend');

            echo "fiber is resumed with the value: ", $value, "\n";
        });

        $value = $fiber->start('one', 'two');

        echo "fiber is started: ", $fiber->isStarted(), "\n";
        echo "Fiber is suspended", $fiber->isSuspended(), "\n";
        echo "Fiber is running", $fiber->isRunning(), "\n";
        echo "fiber is suspended with the value: ", $value, "\n";
        $fiber->resume('resume');
        echo "fiber is running", $fiber->isRunning(), "\n";
    }

    public function reflect(Request $request)
    {
        $reflection = new \ReflectionClass(Suit::class);
        dd(
            $reflection,
            $reflection->hasProperty('value'),
            $reflection->implementsInterface(\BackedEnum::class)
        );
    }

    public function reflectClass()
    {
        $reflection = new \ReflectionClass(HomeController::class);
        dd(
            $reflection,
            array_column($reflection->getMethods(\ReflectionMethod::IS_PUBLIC), 'name'),
            $reflection->getShortName(),
            $reflection->getName()
        );
    }

    public function soapApi()
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'text/xml; charset=utf-8'
        ];
        $body = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <NumberToWords xmlns="http://www.dataaccess.com/webservicesserver/">
      <ubiNum>500</ubiNum>
    </NumberToWords>
  </soap:Body>
</soap:Envelope>';
        $request = new GuzzleRequest('POST', 'https://www.dataaccess.com/webservicesserver/NumberConversion.wso', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        return response()->json($res->getBody()->getContents());

    }

    public function users()
    {
        return response()->json(User::all());
    }

    private function pickACard(Suit $suit): string
    {
        return $suit->name;
    }

    private function pickACardValue(Suit $suit): string
    {
        return $suit->value;
    }
}
