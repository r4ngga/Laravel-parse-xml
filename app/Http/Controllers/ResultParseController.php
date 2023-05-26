<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FileParser;
use App\Models\ResultParser;
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

        $name_file = $request->file('file_xml')->getClientOriginalName();
        // dd($request->file('file_xml')->getClientOriginalName());
        // $imgName = $request->image_book->getClientOriginalName() . '-' . time() . '.' . $request->image_book->extension();
        // $request->image_book->move(public_path('images'), $imgName);
        $location_file = $request->file('file_xml')->move(public_path('xml'), $name_file);
        $save_file_parse = new FileParser();
        $save_file_parse->name_file = $name_file;
        $save_file_parse->file_location = $location_file;
        $save_file_parse->save();

        $find_last_record = FileParser::where('name_file', $name_file)->first();
        $xml = XmlParser::load($find_last_record->file_location);
        $res_pars = $xml->parse([
            'questiontype' => ['uses' => 'question::type'],
            'questiontext' => ['uses' => 'question.questiontext.text'],
            'name' => ['uses' => 'question.name.text'],
            'defaultgrade' => ['uses' => 'question.defaultgrade'],
            'penalty' => ['uses' => 'question.penalty'],
            'answer' => ['uses' => 'question.answer[text]',
            ],
            'answercorrect' => ['uses' => 'question.answer[::fraction]'],
            'shownumcorrect' => ['uses' => 'question.shownumcorrect.text']
        ]);

        // $parser = $xml->parse([
        //     'products' => ['uses' => 'products.product[attributes.attribute_group.value(::name=@)]'],
        // ]);

        // $user = $xml->parse([
        //     'id' => ['uses' => 'user.id'],
        //     'email' => ['uses' => 'user.email'],
        //     'followers' => ['uses' => 'user::followers'],
        // ]);
        // dd($res_pars['answer'][0]['text']);
        // dd($res_pars['answercorrect'][4]['::fraction']);
        // dd($res_pars);

        $result_parse = new ResultParser();

        $result_parse->soal = $res_pars['questiontext'];
        $result_parse->jenis = $res_pars['questiontype'];
        $result_parse->a = $res_pars['answer'][0]['text'];
        $result_parse->b = $res_pars['answer'][1]['text'];
        $result_parse->c = $res_pars['answer'][2]['text'];
        $result_parse->d = $res_pars['answer'][3]['text'];
        $result_parse->e = $res_pars['answer'][4]['text'];
        if($res_pars['answercorrect'][0]['::fraction'] != '0')
        {
             $result_parse->jawaban = 'a';
        }
         if($res_pars['answercorrect'][1]['::fraction'] != '0')
        {
             $result_parse->jawaban = 'b';
        }
         if($res_pars['answercorrect'][2]['::fraction'] != '0')
        {
             $result_parse->jawaban = 'c';
        }
         if($res_pars['answercorrect'][3]['::fraction'] != '0')
        {
             $result_parse->jawaban = 'd';
        }
         if($res_pars['answercorrect'][4]['::fraction'] != '0')
        {
             $result_parse->jawaban = 'e';
        }
        foreach($res_pars['answercorrect'] as $key => $score){
            // dd($score[$key]['::fraction'] );
            if($score['::fraction'] > 0){
                $result_parse->score = $score['::fraction'];
            }

            //if($score['::fraction'] != 0){
                //$result_parse->jawaban

            //}
        }
        // $result_parse->jawaban = '';
        $result_parse->save();
        return redirect()->back();

    }
}
