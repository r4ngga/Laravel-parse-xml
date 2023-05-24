<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Orchestra\Parser\Xml\Facade as XmlParser;

class ResultParseController extends Controller
{
    public function index(){
        return view('parse.index');
    }

    public function parse(Request $request){
        $parse_file = $request->file_xml;
        // dd($parse_file);

        // $stream = fopen($parse_file, 'r');
        // $parser = xml_parser_create();

        // while (($data = fread($stream, 16384))) {
        //     xml_parse($parser, $data); // parse the current chunk
        // }
        // xml_parse($parser, '', true); // finalize parsing
        // xml_parser_free($parser);
        // fclose($stream);
        // dd($stream);

        // $xml = XmlParser::load(public_path('xml/questions-English Course 1-Multiple Choice-20230517-1146.xml'));
        $xml = XmlParser::load($parse_file);
        dd($xml);
        $user = $xml->parse([
            'questiontext' => '',
        ]);
    }
}
