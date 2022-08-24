<?php
declare(strict_types=1);

namespace App\Components\Admin\DocumentScraper;

use Generator;
use mysql_xdevapi\Exception;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\Node\HtmlNode;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\ContentLengthException;
use PHPHtmlParser\Exceptions\LogicalException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\ParentNotFoundException;
use PHPHtmlParser\Exceptions\StrictException;
use Psr\Scraper\Contracts\ResourceFetcherInterface;
use Psr\Scraper\Contracts\ResourceParserInterface;
use Throwable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class DocumentHtmlParser implements ResourceParserInterface
{
    private const SECTION_TITLE_PREFIX = 'Розділ';
    private const ARTICLE_TITLE_PREFIX = 'Стаття';

    private ResourceFetcherInterface $resourceFetcher;

    public function __construct(ResourceFetcherInterface $resourceFetcher)
    {
        $this->resourceFetcher = $resourceFetcher;
    }

    /**
     * @param array $resourceData
     *
     * @return array
     *
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws ContentLengthException
     * @throws LogicalException
     * @throws NotLoadedException
     * @throws ParentNotFoundException
     * @throws StrictException
     */
    public function parse(array $resourceData): array
    {
        $res = Http::withHeaders([
            'UserAgent' => "4dcca956-c1a5-4fa0-8497-20baf670f337",
        ])->get($resourceData['resource']);

        $obj = json_decode($res->body());
        $sections = [];
        $sectionsIndex = -1;

     /*   foreach ( $obj->stru  as $key  => $item) {

            if( mb_substr($key,0,1) == "n")
            {
                if(isset($item->level))
                {
                    if($item->typ == "RZ")
                    {
                        $sectionsIndex++;

                        $sections[$sectionsIndex]['title'] = mb_substr( strip_tags($item->text),0,249);
                        $sections[$sectionsIndex]['description'] = '';
                        if(!empty( $item->subtree))
                        {
                            $pieces = explode(",", $item->subtree);

                            $punkt_article = [
                                'title' => '',
                                'text' => '',
                            ];
                            foreach ($pieces as $piece)
                            {
                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "ST"){

                                    $article = [
                                        'title' => '',
                                        'text' => '',
                                    ];
                                    if(!empty( $obj->stru->$piece->text))
                                    {
                                        $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece ) {
                                                if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                            }
                                        } else {
                                            $article['text'] .= " ";
                                        }
                                        $sections[$sectionsIndex]['articles'][] = $article;
                                    }

                                }

                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                {
                                    $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                    foreach ($g_pieces as $g_piece)
                                    {
                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if($obj->stru->$g_piece->typ == "ST")
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$g_piece->text),0,249);
                                            $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    $article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }
                                    }
                                }

                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PR"){

                                    $article = [
                                        'title' => '',
                                        'text' => '',
                                    ];
                                    if(!empty( $obj->stru->$piece->text))
                                    {
                                        $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece ) {
                                                if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                            }
                                        } else {
                                            $article['text'] .= " ";
                                        }
                                        $sections[$sectionsIndex]['articles'][] = $article;
                                    }

                                }

                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                    $punkt_article['title'] = "Пункти";
                                    $punkt_article['text'] .= $obj->stru->$piece->text;
                                    if(!empty($obj->stru->$piece->subtree))
                                    {
                                        $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($a_pieces as $a_piece)
                                        {
                                            if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                            {
                                                if(!empty( $obj->stru->$a_piece->text))
                                                {
                                                    $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                                if(!empty( $obj->stru->$a_piece->subtree))
                                                {
                                                    $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                    foreach ($aa_pieces as $aa_piece)
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                if(($obj->stru->$piece->level == 3) && $obj->stru->$piece->typ == "PP"){
                                    $punkt_article['title'] = "Пункти";
                                    $punkt_article['text'] .= $obj->stru->$piece->text;
                                    if(!empty($obj->stru->$piece->subtree))
                                    {
                                        $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($a_pieces as $a_piece)
                                        {
                                            if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                            {
                                                if(!empty( $obj->stru->$a_piece->text))
                                                {
                                                    $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                                if(!empty( $obj->stru->$a_piece->subtree))
                                                {
                                                    $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                    foreach ($aa_pieces as $aa_piece)
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if(!empty($punkt_article['title']))
                            {
                                $sections[$sectionsIndex]['articles'][] = $punkt_article;
                            }
                        }
                    }
                    elseif($item->typ == "GL" && $item->level == 2)
                    {
                        $sectionsIndex++;

                        $sections[$sectionsIndex]['title'] = mb_substr( strip_tags($item->text),0,249);
                        $sections[$sectionsIndex]['description'] = '';
                        if(!empty( $item->subtree))
                        {
                            $pieces = explode(",", $item->subtree);

                            $punkt_article = [
                                'title' => '',
                                'text' => '',
                            ];
                            foreach ($pieces as $piece)
                            {
                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && ($obj->stru->$piece->typ == "ST" || $obj->stru->$piece->typ == "CH")){

                                    $article = [
                                        'title' => '',
                                        'text' => '',
                                    ];
                                    if(!empty( $obj->stru->$piece->text))
                                    {
                                        $article['title'] = mb_substr(strip_tags($obj->stru->$piece->text),0,249);

                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece ) {
                                                if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                            }
                                        } else {
                                            $article['text'] .= " ";
                                        }
                                        $sections[$sectionsIndex]['articles'][] = $article;
                                    }

                                }

                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                {
                                    $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                    foreach ($g_pieces as $g_piece)
                                    {
                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if($obj->stru->$g_piece->typ == "ST")
                                        {
                                            $article['title'] = mb_substr(strip_tags($obj->stru->$g_piece->text),0,249);
                                            $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    $article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }
                                    }
                                }



                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                    $punkt_article['title'] = "Пункти";
                                    $punkt_article['text'] .= $obj->stru->$piece->text;
                                    if(!empty($obj->stru->$piece->subtree))
                                    {
                                        $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($a_pieces as $a_piece)
                                        {
                                            if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                            {
                                                if(!empty( $obj->stru->$a_piece->text))
                                                {
                                                    $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                                if(!empty( $obj->stru->$a_piece->subtree))
                                                {
                                                    $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                    foreach ($aa_pieces as $aa_piece)
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }


                            }
                            if(!empty($punkt_article['title']))
                            {
                                $sections[$sectionsIndex]['articles'][] = $punkt_article;
                            }
                        }
                    }
                    elseif($item->typ == "ST" && $item->level == 2)
                    {
                        $sections[0]['title'] = 'ЗАГАЛЬНИЙ РОЗДІЛ';
                        $sections[0]['description'] = '';
                        if(!empty( $item->subtree))
                        {
                            $pieces = explode(",", $item->subtree);

                            $punkt_article = [
                                'title' => '',
                                'text' => '',
                            ];
                            foreach ($pieces as $piece)
                            {
                                if($obj->stru->$piece->typ == "ST"){

                                    $article = [
                                        'title' => '',
                                        'text' => '',
                                    ];
                                    if(!empty( $obj->stru->$piece->text))
                                    {
                                        $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece ) {
                                                if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                            }
                                        } else {
                                            $article['text'] .= " ";
                                        }
                                        $sections[0]['articles'][] = $article;
                                    }

                                }


                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                    $punkt_article['title'] = "Пункти";
                                    $punkt_article['text'] .= $obj->stru->$piece->text;
                                    if(!empty($obj->stru->$piece->subtree))
                                    {
                                        $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($a_pieces as $a_piece)
                                        {
                                            if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                            {
                                                if(!empty( $obj->stru->$a_piece->text))
                                                {
                                                    $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                                if(!empty( $obj->stru->$a_piece->subtree))
                                                {
                                                    $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                    foreach ($aa_pieces as $aa_piece)
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }


                            }
                            if(!empty($punkt_article['title']))
                            {
                                $sections[0]['articles'][] = $punkt_article;
                            }
                        }
                    }
                }
            }
            elseif( mb_substr($key,0,1) == "o")
            {
                if(isset($item->level))
                {
                    if($item->typ == "RZ")
                    {
                        $sectionsIndex++;

                        $sections[$sectionsIndex]['title'] = mb_substr(strip_tags($item->text),0,249);
                        $sections[$sectionsIndex]['description'] = '';
                        if(!empty( $item->subtree))
                        {
                            $pieces = explode(",", $item->subtree);

                            $punkt_article = [
                                'title' => '',
                                'text' => '',
                            ];
                            foreach ($pieces as $piece)
                            {
                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "ST"){

                                    $article = [
                                        'title' => '',
                                        'text' => '',
                                    ];
                                    if(!empty( $obj->stru->$piece->text))
                                    {
                                        $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece ) {
                                                if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                            }
                                        } else {
                                            $article['text'] .= " ";
                                        }
                                        $sections[$sectionsIndex]['articles'][] = $article;
                                    }

                                }

                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                {
                                    $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                    foreach ($g_pieces as $g_piece)
                                    {
                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if($obj->stru->$g_piece->typ == "ST")
                                        {
                                            $article['title'] = $article['title'] = mb_substr( strip_tags($obj->stru->$g_piece->text),0,249);
                                            $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    $article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }
                                    }
                                }



                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                    $punkt_article['title'] = "Пункти";
                                    $punkt_article['text'] .= $obj->stru->$piece->text;
                                    if(!empty($obj->stru->$piece->subtree))
                                    {
                                        $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($a_pieces as $a_piece)
                                        {
                                            if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                            {
                                                if(!empty( $obj->stru->$a_piece->text))
                                                {
                                                    $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                                if(!empty( $obj->stru->$a_piece->subtree))
                                                {
                                                    $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                    foreach ($aa_pieces as $aa_piece)
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                if(($obj->stru->$piece->level == 3) && $obj->stru->$piece->typ == "PP"){
                                    $punkt_article['title'] = "Пункти";
                                    $punkt_article['text'] .= $obj->stru->$piece->text;
                                    if(!empty($obj->stru->$piece->subtree))
                                    {
                                        $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($a_pieces as $a_piece)
                                        {
                                            if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                            {
                                                if(!empty( $obj->stru->$a_piece->text))
                                                {
                                                    $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                                if(!empty( $obj->stru->$a_piece->subtree))
                                                {
                                                    $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                    foreach ($aa_pieces as $aa_piece)
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if(!empty($punkt_article['title']))
                            {
                                $sections[$sectionsIndex]['articles'][] = $punkt_article;
                            }
                        }
                    }
                    elseif($item->typ == "GL" && $item->level == 2)
                    {
                        $sectionsIndex++;

                        $sections[$sectionsIndex]['title'] = mb_substr( strip_tags($item->text),0,249);
                        $sections[$sectionsIndex]['description'] = '';
                        if(!empty( $item->subtree))
                        {
                            $pieces = explode(",", $item->subtree);

                            $punkt_article = [
                                'title' => '',
                                'text' => '',
                            ];
                            foreach ($pieces as $piece)
                            {
                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && ($obj->stru->$piece->typ == "ST" || $obj->stru->$piece->typ == "CH")){

                                    $article = [
                                        'title' => '',
                                        'text' => '',
                                    ];
                                    if(!empty( $obj->stru->$piece->text))
                                    {
                                        $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece ) {
                                                if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                            }
                                        } else {
                                            $article['text'] .= " ";
                                        }
                                        $sections[$sectionsIndex]['articles'][] = $article;
                                    }

                                }

                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                {
                                    $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                    foreach ($g_pieces as $g_piece)
                                    {
                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if($obj->stru->$g_piece->typ == "ST")
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$g_piece->text),0,249);
                                            $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    $article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }
                                    }
                                }



                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                    $punkt_article['title'] = "Пункти";
                                    $punkt_article['text'] .= $obj->stru->$piece->text;
                                    if(!empty($obj->stru->$piece->subtree))
                                    {
                                        $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($a_pieces as $a_piece)
                                        {
                                            if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                            {
                                                if(!empty( $obj->stru->$a_piece->text))
                                                {
                                                    $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                                if(!empty( $obj->stru->$a_piece->subtree))
                                                {
                                                    $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                    foreach ($aa_pieces as $aa_piece)
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }


                            }
                            if(!empty($punkt_article['title']))
                            {
                                $sections[$sectionsIndex]['articles'][] = $punkt_article;
                            }
                        }
                    }
                    elseif($item->typ == "ST" && $item->level == 2)
                    {
                        $sections[0]['title'] = 'ЗАГАЛЬНИЙ РОЗДІЛ';
                        $sections[0]['description'] = '';
                        if(!empty( $item->subtree))
                        {
                            $pieces = explode(",", $item->subtree);

                            $punkt_article = [
                                'title' => '',
                                'text' => '',
                            ];
                            foreach ($pieces as $piece)
                            {
                                if($obj->stru->$piece->typ == "ST"){

                                    $article = [
                                        'title' => '',
                                        'text' => '',
                                    ];
                                    if(!empty( $obj->stru->$piece->text))
                                    {
                                        $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece ) {
                                                if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                            }
                                        } else {
                                            $article['text'] .= " ";
                                        }
                                        $sections[0]['articles'][] = $article;
                                    }

                                }


                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                    $punkt_article['title'] = "Пункти";
                                    $punkt_article['text'] .= $obj->stru->$piece->text;
                                    if(!empty($obj->stru->$piece->subtree))
                                    {
                                        $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($a_pieces as $a_piece)
                                        {
                                            if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                            {
                                                if(!empty( $obj->stru->$a_piece->text))
                                                {
                                                    $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                                if(!empty( $obj->stru->$a_piece->subtree))
                                                {
                                                    $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                    foreach ($aa_pieces as $aa_piece)
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }


                            }
                            if(!empty($punkt_article['title']))
                            {
                                $sections[0]['articles'][] = $punkt_article;
                            }
                        }
                    }
                    elseif($item->typ == "PU" && $item->level == 2)
                    {
                        $sectionsIndex++;

                        $sections[$sectionsIndex]['title'] = mb_substr($item->text,0,249) ;
                        $sections[$sectionsIndex]['description'] = '';
                        if(!empty( $item->subtree))
                        {
                            $pieces = explode(",", $item->subtree);

                            $punkt_article = [
                                'title' => '',
                                'text' => '',
                            ];
                            foreach ($pieces as $piece)
                            {
                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "ST"){

                                    $article = [
                                        'title' => '',
                                        'text' => '',
                                    ];
                                    if(!empty( $obj->stru->$piece->text))
                                    {
                                        $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece ) {
                                                if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                            }
                                        } else {
                                            $article['text'] .= " ";
                                        }
                                        $sections[$sectionsIndex]['articles'][] = $article;
                                    }

                                }

                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                {
                                    $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                    foreach ($g_pieces as $g_piece)
                                    {
                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if($obj->stru->$g_piece->typ == "ST")
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$g_piece->text),0,249);
                                            $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                {
                                                    $article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }
                                    }
                                }

                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && ($obj->stru->$piece->typ == "PU" || $obj->stru->$piece->typ == "PP" || $obj->stru->$piece->typ == "CH")){
                                    $punkt_article['title'] = "Пункти";
                                    $punkt_article['text'] .= $obj->stru->$piece->text;
                                    if(!empty($obj->stru->$piece->subtree))
                                    {
                                        $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($a_pieces as $a_piece)
                                        {
                                            if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                            {
                                                if(!empty( $obj->stru->$a_piece->text))
                                                {
                                                    $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                }
                                                if(!empty( $obj->stru->$a_piece->subtree))
                                                {
                                                    $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                    foreach ($aa_pieces as $aa_piece)
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }


                            }
                            if(!empty($punkt_article['title']))
                            {
                                $sections[$sectionsIndex]['articles'][] = $punkt_article;
                            }
                        }
                    }
                }
            }
        }*/

        foreach ( $obj->stru  as $key  => $item) {
            if( mb_substr($key,0,1) == "n"){
                if(isset($item->level) && $item->level == 1 && !empty( $item->subtree))
                {
                    $children = explode(",", $item->subtree);
                    foreach ($children as $child)
                    {
                        if($obj->stru->$child->level == 2 && !empty( $obj->stru->$child->align) && $obj->stru->$child->align == 'C' && $obj->stru->$child->typ !='CM')
                        {
                            $sectionsIndex++;

                            $sections[$sectionsIndex]['title'] = mb_substr($obj->stru->$child->text,0,249);
                            $sections[$sectionsIndex]['description'] = mb_substr($obj->stru->$child->text,0,249);
                            if( !empty( $obj->stru->$child->subtree))
                            {
                                $sub_pieces = explode(",", $obj->stru->$child->subtree);
                                foreach ($sub_pieces as $subtree)
                                {
                                    if($subtree != $obj->stru->$child->id)
                                    {
                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        $article['title'] = mb_substr( strip_tags($obj->stru->$subtree->text),0,249);
                                        $article['text'] .= $obj->stru->$subtree->text;
                                        $sections[$sectionsIndex]['articles'][] = $article;
                                    }

                                }

                            }
                        }
                        if($obj->stru->$child->level >= 2 && !empty( $obj->stru->$child->align)  &&  $obj->stru->$child->align != 'C'  && $obj->stru->$child->typ !='CM')
                        {
                            $article = [
                                'title' => '',
                                'text' => '',
                            ];
                            $article['title'] = mb_substr( strip_tags($obj->stru->$child->text),0,249);
                            $article['text'] .= $obj->stru->$child->text;
                            $sections[$sectionsIndex]['articles'][] = $article;
                        }
                    }

                }
            }
            elseif( mb_substr($key,0,1) == "o") {
                if(isset($item->level) && $item->level == 1 && !empty( $item->subtree))
                {
                    $children = explode(",", $item->subtree);
                    foreach ($children as $child)
                    {
                        if($obj->stru->$child->level == 2 && $obj->stru->$child->align == 'C'  && $obj->stru->$child->typ !='CM')
                        {
                            $sectionsIndex++;
                            $article = [
                                'title' => '',
                                'text' => '',
                            ];

                            $sections[$sectionsIndex]['title'] = mb_substr($obj->stru->$child->text,0,249);
                            $sections[$sectionsIndex]['description'] = mb_substr($obj->stru->$child->text,0,249);
                            if( !empty( $obj->stru->$child->subtree))
                            {
                                $sub_pieces = explode(",", $obj->stru->$child->subtree);
                                foreach ($sub_pieces as $subtree)
                                {
                                    if($subtree != $obj->stru->$child->id)
                                    {

                                        $article['title'] = mb_substr( strip_tags($obj->stru->$subtree->text),0,249);
                                        $article['text'] .= $obj->stru->$subtree->text;

                                    }

                                }

                            }
                            $sections[$sectionsIndex]['articles'][] = $article;
                        }
                        if($obj->stru->$child->level >= 2 && $obj->stru->$child->align != 'C'  && $obj->stru->$child->typ !='CM')
                        {
                            $article = [
                                'title' => '',
                                'text' => '',
                            ];
                            $article['title'] = mb_substr( strip_tags($obj->stru->$child->text),0,249);
                            $article['text'] .= $obj->stru->$child->text;
                            $sections[$sectionsIndex]['articles'][] = $article;
                        }
                    }

                }
            }
        }
        if(empty($sections))
        {
            foreach ( $obj->stru  as $key  => $item) {

                if( mb_substr($key,0,1) == "n")
                {
                    if(isset($item->level))
                    {
                        if($item->typ == "RZ")
                        {
                            $sectionsIndex++;

                            $sections[$sectionsIndex]['title'] = mb_substr( strip_tags($item->text),0,249);
                            $sections[$sectionsIndex]['description'] = '';
                            if(!empty( $item->subtree))
                            {
                                $pieces = explode(",", $item->subtree);

                                $punkt_article = [
                                    'title' => '',
                                    'text' => '',
                                ];
                                foreach ($pieces as $piece)
                                {
                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "ST"){

                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if(!empty( $obj->stru->$piece->text))
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                            if(!empty($obj->stru->$piece->subtree))
                                            {
                                                $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                                foreach ($a_pieces as $a_piece ) {
                                                    if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        if(!empty( $obj->stru->$a_piece->text))
                                                        {
                                                            $article['text'] .= $obj->stru->$a_piece->text;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $article['text'] .= " ";
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }

                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                    {
                                        $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($g_pieces as $g_piece)
                                        {
                                            $article = [
                                                'title' => '',
                                                'text' => '',
                                            ];
                                            if($obj->stru->$g_piece->typ == "ST")
                                            {
                                                $article['title'] = mb_substr( strip_tags($obj->stru->$g_piece->text),0,249);
                                                $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                                foreach ($a_pieces as $a_piece)
                                                {
                                                    if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                                $sections[$sectionsIndex]['articles'][] = $article;
                                            }
                                        }
                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PR"){

                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if(!empty( $obj->stru->$piece->text))
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                            if(!empty($obj->stru->$piece->subtree))
                                            {
                                                $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                                foreach ($a_pieces as $a_piece ) {
                                                    if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        if(!empty( $obj->stru->$a_piece->text))
                                                        {
                                                            $article['text'] .= $obj->stru->$a_piece->text;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $article['text'] .= " ";
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }

                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if(($obj->stru->$piece->level == 3) && $obj->stru->$piece->typ == "PP"){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                if(!empty($punkt_article['title']))
                                {
                                    $sections[$sectionsIndex]['articles'][] = $punkt_article;
                                }
                            }
                        }
                        elseif($item->typ == "GL" && $item->level == 2)
                        {
                            $sectionsIndex++;

                            $sections[$sectionsIndex]['title'] = mb_substr( strip_tags($item->text),0,249);
                            $sections[$sectionsIndex]['description'] = '';
                            if(!empty( $item->subtree))
                            {
                                $pieces = explode(",", $item->subtree);

                                $punkt_article = [
                                    'title' => '',
                                    'text' => '',
                                ];
                                foreach ($pieces as $piece)
                                {
                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && ($obj->stru->$piece->typ == "ST" || $obj->stru->$piece->typ == "CH")){

                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if(!empty( $obj->stru->$piece->text))
                                        {
                                            $article['title'] = mb_substr(strip_tags($obj->stru->$piece->text),0,249);

                                            if(!empty($obj->stru->$piece->subtree))
                                            {
                                                $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                                foreach ($a_pieces as $a_piece ) {
                                                    if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        if(!empty( $obj->stru->$a_piece->text))
                                                        {
                                                            $article['text'] .= $obj->stru->$a_piece->text;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $article['text'] .= " ";
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }

                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                    {
                                        $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($g_pieces as $g_piece)
                                        {
                                            $article = [
                                                'title' => '',
                                                'text' => '',
                                            ];
                                            if($obj->stru->$g_piece->typ == "ST")
                                            {
                                                $article['title'] = mb_substr(strip_tags($obj->stru->$g_piece->text),0,249);
                                                $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                                foreach ($a_pieces as $a_piece)
                                                {
                                                    if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                                $sections[$sectionsIndex]['articles'][] = $article;
                                            }
                                        }
                                    }



                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }


                                }
                                if(!empty($punkt_article['title']))
                                {
                                    $sections[$sectionsIndex]['articles'][] = $punkt_article;
                                }
                            }
                        }
                        elseif($item->typ == "ST" && $item->level == 2)
                        {
                            $sections[0]['title'] = 'ЗАГАЛЬНИЙ РОЗДІЛ';
                            $sections[0]['description'] = '';
                            if(!empty( $item->subtree))
                            {
                                $pieces = explode(",", $item->subtree);

                                $punkt_article = [
                                    'title' => '',
                                    'text' => '',
                                ];
                                foreach ($pieces as $piece)
                                {
                                    if($obj->stru->$piece->typ == "ST"){

                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if(!empty( $obj->stru->$piece->text))
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                            if(!empty($obj->stru->$piece->subtree))
                                            {
                                                $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                                foreach ($a_pieces as $a_piece ) {
                                                    if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        if(!empty( $obj->stru->$a_piece->text))
                                                        {
                                                            $article['text'] .= $obj->stru->$a_piece->text;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $article['text'] .= " ";
                                            }
                                            $sections[0]['articles'][] = $article;
                                        }

                                    }


                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }


                                }
                                if(!empty($punkt_article['title']))
                                {
                                    $sections[0]['articles'][] = $punkt_article;
                                }
                            }
                        }
                        elseif($item->typ == "PU" && $item->level == 2 && !empty( $item->subtree))
                        {
                            $sectionsIndex++;

                            $sections[$sectionsIndex]['title'] = mb_substr($item->text,0,249) ;
                            $sections[$sectionsIndex]['description'] = '';
                            if(!empty( $item->subtree))
                            {
                                $pieces = explode(",", $item->subtree);

                                $punkt_article = [
                                    'title' => '',
                                    'text' => '',
                                ];
                                foreach ($pieces as $piece)
                                {
                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "ST"){

                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if(!empty( $obj->stru->$piece->text))
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                            if(!empty($obj->stru->$piece->subtree))
                                            {
                                                $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                                foreach ($a_pieces as $a_piece ) {
                                                    if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        if(!empty( $obj->stru->$a_piece->text))
                                                        {
                                                            $article['text'] .= $obj->stru->$a_piece->text;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $article['text'] .= " ";
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }

                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                    {
                                        $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($g_pieces as $g_piece)
                                        {
                                            $article = [
                                                'title' => '',
                                                'text' => '',
                                            ];
                                            if($obj->stru->$g_piece->typ == "ST")
                                            {
                                                $article['title'] = mb_substr( strip_tags($obj->stru->$g_piece->text),0,249);
                                                $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                                foreach ($a_pieces as $a_piece)
                                                {
                                                    if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                                $sections[$sectionsIndex]['articles'][] = $article;
                                            }
                                        }
                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && ($obj->stru->$piece->typ == "PU" || $obj->stru->$piece->typ == "PP" || $obj->stru->$piece->typ == "CH")){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }


                                }
                                if(!empty($punkt_article['title']))
                                {
                                    $sections[$sectionsIndex]['articles'][] = $punkt_article;
                                }
                            }
                        }
                    }
                }
                elseif( mb_substr($key,0,1) == "o")
                {
                    if(isset($item->level))
                    {
                        if($item->typ == "RZ")
                        {
                            $sectionsIndex++;

                            $sections[$sectionsIndex]['title'] = mb_substr(strip_tags($item->text),0,249);
                            $sections[$sectionsIndex]['description'] = '';
                            if(!empty( $item->subtree))
                            {
                                $pieces = explode(",", $item->subtree);

                                $punkt_article = [
                                    'title' => '',
                                    'text' => '',
                                ];
                                foreach ($pieces as $piece)
                                {
                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "ST"){

                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if(!empty( $obj->stru->$piece->text))
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                            if(!empty($obj->stru->$piece->subtree))
                                            {
                                                $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                                foreach ($a_pieces as $a_piece ) {
                                                    if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        if(!empty( $obj->stru->$a_piece->text))
                                                        {
                                                            $article['text'] .= $obj->stru->$a_piece->text;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $article['text'] .= " ";
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }

                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                    {
                                        $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($g_pieces as $g_piece)
                                        {
                                            $article = [
                                                'title' => '',
                                                'text' => '',
                                            ];
                                            if($obj->stru->$g_piece->typ == "ST")
                                            {
                                                $article['title'] = $article['title'] = mb_substr( strip_tags($obj->stru->$g_piece->text),0,249);
                                                $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                                foreach ($a_pieces as $a_piece)
                                                {
                                                    if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                                $sections[$sectionsIndex]['articles'][] = $article;
                                            }
                                        }
                                    }



                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if(($obj->stru->$piece->level == 3) && $obj->stru->$piece->typ == "PP"){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                if(!empty($punkt_article['title']))
                                {
                                    $sections[$sectionsIndex]['articles'][] = $punkt_article;
                                }
                            }
                        }
                        elseif($item->typ == "GL" && $item->level == 2)
                        {
                            $sectionsIndex++;

                            $sections[$sectionsIndex]['title'] = mb_substr( strip_tags($item->text),0,249);
                            $sections[$sectionsIndex]['description'] = '';
                            if(!empty( $item->subtree))
                            {
                                $pieces = explode(",", $item->subtree);

                                $punkt_article = [
                                    'title' => '',
                                    'text' => '',
                                ];
                                foreach ($pieces as $piece)
                                {
                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && ($obj->stru->$piece->typ == "ST" || $obj->stru->$piece->typ == "CH")){

                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if(!empty( $obj->stru->$piece->text))
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                            if(!empty($obj->stru->$piece->subtree))
                                            {
                                                $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                                foreach ($a_pieces as $a_piece ) {
                                                    if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        if(!empty( $obj->stru->$a_piece->text))
                                                        {
                                                            $article['text'] .= $obj->stru->$a_piece->text;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $article['text'] .= " ";
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }

                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                    {
                                        $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($g_pieces as $g_piece)
                                        {
                                            $article = [
                                                'title' => '',
                                                'text' => '',
                                            ];
                                            if($obj->stru->$g_piece->typ == "ST")
                                            {
                                                $article['title'] = mb_substr( strip_tags($obj->stru->$g_piece->text),0,249);
                                                $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                                foreach ($a_pieces as $a_piece)
                                                {
                                                    if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                                $sections[$sectionsIndex]['articles'][] = $article;
                                            }
                                        }
                                    }



                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }


                                }
                                if(!empty($punkt_article['title']))
                                {
                                    $sections[$sectionsIndex]['articles'][] = $punkt_article;
                                }
                            }
                        }
                        elseif($item->typ == "ST" && $item->level == 2)
                        {
                            $sections[0]['title'] = 'ЗАГАЛЬНИЙ РОЗДІЛ';
                            $sections[0]['description'] = '';
                            if(!empty( $item->subtree))
                            {
                                $pieces = explode(",", $item->subtree);

                                $punkt_article = [
                                    'title' => '',
                                    'text' => '',
                                ];
                                foreach ($pieces as $piece)
                                {
                                    if($obj->stru->$piece->typ == "ST"){

                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if(!empty( $obj->stru->$piece->text))
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                            if(!empty($obj->stru->$piece->subtree))
                                            {
                                                $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                                foreach ($a_pieces as $a_piece ) {
                                                    if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        if(!empty( $obj->stru->$a_piece->text))
                                                        {
                                                            $article['text'] .= $obj->stru->$a_piece->text;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $article['text'] .= " ";
                                            }
                                            $sections[0]['articles'][] = $article;
                                        }

                                    }


                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "PU"){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }


                                }
                                if(!empty($punkt_article['title']))
                                {
                                    $sections[0]['articles'][] = $punkt_article;
                                }
                            }
                        }
                        elseif($item->typ == "PU" && $item->level == 2 && !empty( $item->subtree))
                        {
                            $sectionsIndex++;

                            $sections[$sectionsIndex]['title'] = mb_substr($item->text,0,249) ;
                            $sections[$sectionsIndex]['description'] = '';
                            if(!empty( $item->subtree))
                            {
                                $pieces = explode(",", $item->subtree);

                                $punkt_article = [
                                    'title' => '',
                                    'text' => '',
                                ];
                                foreach ($pieces as $piece)
                                {
                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "ST"){

                                        $article = [
                                            'title' => '',
                                            'text' => '',
                                        ];
                                        if(!empty( $obj->stru->$piece->text))
                                        {
                                            $article['title'] = mb_substr( strip_tags($obj->stru->$piece->text),0,249);

                                            if(!empty($obj->stru->$piece->subtree))
                                            {
                                                $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                                foreach ($a_pieces as $a_piece ) {
                                                    if($a_piece != $obj->stru->$piece->id &&  ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        if(!empty( $obj->stru->$a_piece->text))
                                                        {
                                                            $article['text'] .= $obj->stru->$a_piece->text;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $article['text'] .= " ";
                                            }
                                            $sections[$sectionsIndex]['articles'][] = $article;
                                        }

                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && $obj->stru->$piece->typ == "GL")
                                    {
                                        $g_pieces = explode(",", $obj->stru->$piece->subtree);
                                        foreach ($g_pieces as $g_piece)
                                        {
                                            $article = [
                                                'title' => '',
                                                'text' => '',
                                            ];
                                            if($obj->stru->$g_piece->typ == "ST")
                                            {
                                                $article['title'] = mb_substr( strip_tags($obj->stru->$g_piece->text),0,249);
                                                $a_pieces = explode(",", $obj->stru->$g_piece->subtree);
                                                foreach ($a_pieces as $a_piece)
                                                {
                                                    if($a_piece != $obj->stru->$g_piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP" || $obj->stru->$a_piece->typ == "PU"))
                                                    {
                                                        $article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                }
                                                $sections[$sectionsIndex]['articles'][] = $article;
                                            }
                                        }
                                    }

                                    if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && ($obj->stru->$piece->typ == "PU" || $obj->stru->$piece->typ == "PP" || $obj->stru->$piece->typ == "CH")){
                                        $punkt_article['title'] = "Пункти";
                                        $punkt_article['text'] .= $obj->stru->$piece->text;
                                        if(!empty($obj->stru->$piece->subtree))
                                        {
                                            $a_pieces = explode(",", $obj->stru->$piece->subtree);
                                            foreach ($a_pieces as $a_piece)
                                            {
                                                if($a_piece != $obj->stru->$piece->id && ($obj->stru->$a_piece->typ == "CH" || $obj->stru->$a_piece->typ == "PP"))
                                                {
                                                    if(!empty( $obj->stru->$a_piece->text))
                                                    {
                                                        $punkt_article['text'] .= $obj->stru->$a_piece->text;
                                                    }
                                                    if(!empty( $obj->stru->$a_piece->subtree))
                                                    {
                                                        $aa_pieces = explode(",", $obj->stru->$piece->subtree);
                                                        foreach ($aa_pieces as $aa_piece)
                                                        {
                                                            $punkt_article['text'] .= $obj->stru->$aa_piece->text;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }


                                }
                                if(!empty($punkt_article['title']))
                                {
                                    $sections[$sectionsIndex]['articles'][] = $punkt_article;
                                }
                            }
                        }
                    }
                }
            }
        }
        if (array_key_exists('-1', $sections)) {
            $sectionsIndex++;
            $sections[$sectionsIndex]['title'] = 'Загальні положення';
            $sections[$sectionsIndex]['description'] = 'Загальні положення';
            $sections[$sectionsIndex]['articles'] = $sections['-1']['articles'];
            unset($sections['-1']);
        }
        $postanova = false;
        foreach ( $obj->stru  as $key  => $item) {
            if( mb_substr($key,0,1) == "n"){
                if(isset($item->level) && $item->level == 1  && isset($item->stru ) &&  $item->stru == 'ПОСТАНОВА')
                {
                    $postanova = true;
                }
            }
            elseif( mb_substr($key,0,1) == "o") {
                if(isset($item->level) && $item->level == 1  && isset($item->stru )   && $item->stru == 'ПОСТАНОВА')
                {
                    $postanova = true;
                }
            }
        }
        if($postanova)
        {
            unset($sections);
            $sectionsIndex = 0;
            $punkt_article = [
                'title' => 'Положення',
                'text' => '',
            ];
            foreach ( $obj->stru  as $key  => $item) {
                if( mb_substr($key,0,1) == "n"){
                    if(isset($item->level) && $item->level == 1  && !empty( $item->subtree))
                    {
                        $sections[$sectionsIndex]['title'] = mb_substr($item->text,0,249);
                        $sections[$sectionsIndex]['description'] = mb_substr($item->text,0,249);
                        $children = explode(",", $item->subtree);
                        foreach ($children as $child)
                        {
                            if($obj->stru->$child->level >= 2 )
                            {
                                $punkt_article['text'] .= $obj->stru->$child->text;
                            }
                        }

                    }
                }
                elseif( mb_substr($key,0,1) == "o") {
                    if(isset($item->level) && $item->level == 1  && !empty( $item->subtree))
                    {
                        $sections[$sectionsIndex]['title'] = mb_substr($item->text,0,249);
                        $sections[$sectionsIndex]['description'] = mb_substr($item->text,0,249);
                        $children = explode(",", $item->subtree);
                        foreach ($children as $child)
                        {
                            if($obj->stru->$child->level >= 2 )
                            {
                                $punkt_article['text'] .= $obj->stru->$child->text;
                            }
                        }

                    }
                }
            }
            $sections[$sectionsIndex]['articles'][] = $punkt_article;
        }
        return [
            'name' =>   mb_substr( strip_tags($obj->nazva),0,249),
            'description' =>  mb_substr( strip_tags($obj->nazva),0,249),
            'sections' => $sections,
        ];

    }

    /**
     * @param string[] $resourceData
     *
     * @return string
     */
    private function fetchRealContent(array $resourceData): string
    {
        $parsedResourceUrl = parse_url($resourceData['resource']);


        $dom = new Dom();
        try {
            $path = $dom->loadStr($resourceData['content'])
                ->find('section', 0)
                ->getAttribute('data-load');
        } catch (Throwable $e) {
            $path = null;
        }


        if ($path !== null) {
            $url = "{$parsedResourceUrl['scheme']}://{$parsedResourceUrl['host']}{$path}";
            $content = $this->resourceFetcher->fetch($url);
        }

        return $content ?? $resourceData['content'];
    }

    private function getDocumentName(HtmlNode $contentsItem, string $default = ''): string
    {
        try {
            $originName = $contentsItem->find('a', 0)
                ->getAttribute('title');
        } catch (Throwable $e) {
            $originName = $default;
        }

        return $this->strToLowerAndUpFirst($originName);
    }

    private function getDocumentDescription(Dom $documentSegment, string $default = ''): string
    {
        $prefix = 'Редакція від';

        try {
            $originDesc = $documentSegment->getElementById('edition')
                ->find('select', 0)
                ->find('option[selected]', 0)
                ->innerText();

            preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}/', $originDesc, $matches);
            $desc = $matches[0];
        } catch (Throwable $e) {
            $desc = $default;
        }

        return "{$prefix} {$desc}";
    }

    private function getDocumentSectionTitle(HtmlNode $tag, HtmlNode $sectionsSegment, string $default = ''): string
    {
        try {
            $sectionAnchor = $this->followInternalLink($tag, $sectionsSegment);
            /** @var HtmlNode $sectionParagraph */
            $sectionParagraph = $sectionAnchor->getParent();

            $title =  preg_replace("#<(.*)/(.*)>#iUs", "",$sectionParagraph->innerHtml());
        } catch (Throwable $e) {
            $title = $default;
        }

        return $this->formatDocumentSectionTitle($title);
    }

    /**
     * @param string[] $articles
     * @param string $default
     *
     * @return string
     */
    private function getDocumentSectionDescription(array $articles, string $default = ''): string
    {
        $quantity = count($articles);
        if ($quantity > 1) {
            $desc = $this->getDocumentSectionDescriptionForPlural(
                ...$this->getFirstAndLastTitle($articles)
            );
        } elseif ($quantity === 1) {
            $desc = $this->getDocumentSectionDescriptionForSingle($articles[0]['title']);
        }

        return $desc ?? $default;
    }

    private function getDocumentSectionDescriptionForSingle(string $articleTitle): string
    {
        $prefix = 'Стаття';

        $articleNumber = $this->getArticleNumberFromTitle($articleTitle);

        return "{$prefix} {$articleNumber}";
    }

    private function getDocumentSectionDescriptionForPlural(string $firstArticleTitle, string $lastArticleTitle): string
    {
        $prefix = 'Статті';

        $firstArticleNumber = $this->getArticleNumberFromTitle($firstArticleTitle);
        $lastArticleNumber = $this->getArticleNumberFromTitle($lastArticleTitle);

        return "{$prefix} {$firstArticleNumber}-{$lastArticleNumber}";
    }

    private function getArticleNumberFromTitle($articleTitle): string
    {
        $pattern = '/^' . self::ARTICLE_TITLE_PREFIX . ' (\d+)\./';
        preg_match($pattern, $articleTitle, $matches);

        return $matches[1] ?? '#';
    }

    /**
     * @param HtmlNode $articleAnchor
     * @param HtmlNode $articlesSegment
     *
     * @return string[]
     */
    private function getDocumentSectionArticle(HtmlNode $articleAnchor, HtmlNode $articlesSegment): array
    {
        try {
            $articleTextAnchor = $this->followInternalLink($articleAnchor, $articlesSegment);

            /** @var HtmlNode $firstArticleParagraph */
            $firstArticleParagraph = $articleTextAnchor->getParent();
            $originArticleTitle =  preg_replace("#<(.*)/(.*)>#iUs", "",$firstArticleParagraph->innerHtml());
            $articleTitle = $this->formatDocumentSectionArticleTitle($originArticleTitle);

            $originArticleText = '';
            foreach ($this->jumpOverEmptySiblingTagIterator($firstArticleParagraph) as $paragraph) {
                if ($paragraph->getTag()->name() !== 'p') {
                    $paragraph = $paragraph->find('p.rvps2', 0);

                    if ($paragraph === null) {
                        break;
                    }
                }
                /** @var HtmlNode $paragraphAnchor */
                $paragraphAnchor = $paragraph->firstChild();
                $dataTree = $paragraphAnchor->getAttribute('data-tree');

                $isNextArticle = preg_match('/^st\d+$/', $dataTree);
                if ($isNextArticle === 1) {
                    break;
                }

                $originArticleText .=  preg_replace("#<(.*)/(.*)>#iUs", "",$paragraph->innerHtml());
            }
            $articleText = trim($originArticleText);
        } catch (Throwable $e) {
            $articleTitle = $articleTitle
                ?? '';
            $articleText = $articleText
                ?? '';
        }

        return [
            'title' => $articleTitle,
            'text' => $articleText,
        ];
    }

    private function formatDocumentSectionTitle(string $originTitle): string
    {
        $originTitle = trim($originTitle);
        $originTitle = str_replace('  ', ' ', $originTitle);

        $titleElements = explode(' ', $originTitle, 3);

        $titleElements[1] = $this->convertRomanToNumber($titleElements[1]);

        $titleElements[2] = $this->strToLowerAndUpFirst($titleElements[2]);

        return implode(' ', $titleElements);
    }

    private function formatDocumentSectionArticleTitle(string $originTitle): string
    {
        return trim($originTitle, ' \t\n\r\0\x0B";');
    }

    /**
     * @param HtmlNode $tag
     *
     * @return HtmlNode[]|Generator
     *
     * @throws ChildNotFoundException
     * @throws ParentNotFoundException
     */
    private function jumpOverEmptySiblingTagIterator(HtmlNode $tag): Generator
    {
        while ($tag->hasNextSibling()) {
            $tag = $tag->nextSibling();
            if (empty(trim((string) $tag))) {
                continue;
            }

            yield $tag;
        }
    }

    /**
     * @param HtmlNode $linkTag
     * @param HtmlNode $context
     *
     * @return HtmlNode|null
     *
     * @throws ChildNotFoundException
     */
    private function followInternalLink(HtmlNode $linkTag, HtmlNode $context)
    {
        $href = ltrim($linkTag->getAttribute('href'), '#');

        return $context->find("a[name='{$href}']", 0);
    }

    private function strToLowerAndUpFirst(string $text): string
    {
        $firstChar = mb_mb_substr($text, 0, 1);
        $tail = mb_mb_substr($text, 1);

        return $firstChar . mb_strtolower($tail);
    }

    private function convertRomanToNumber(string $romanNumeral): int
    {
        $romanToArabicMap = [
            'I' => 1,
            'V' => 5,
            'X' => 10,
            'L' => 50,
            'C' => 100,
            'D' => 500,
            'M' => 1000,
        ];

        $resultNumber = 0;
        $previewsNumber = 0;
        foreach (str_split($romanNumeral) as $char) {
            $convertedNumber = $romanToArabicMap[$char];
            $resultNumber += $previewsNumber < $convertedNumber
                ? $convertedNumber - $previewsNumber * 2
                : $convertedNumber;

            $previewsNumber = $convertedNumber;
        }

        return $resultNumber;
    }

    private function getFirstAndLastTitle(array $array): array
    {
        return [
            $array[0]['title'],
            $array[count($array) - 1]['title'],
        ];
    }
}
