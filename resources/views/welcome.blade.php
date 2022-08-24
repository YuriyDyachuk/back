<?php
use Illuminate\Support\Facades\Http;

$res = Http::withHeaders([
    'UserAgent' => "4dcca956-c1a5-4fa0-8497-20baf670f337",
])->get('https://data.rada.gov.ua/laws/show/z1086-08.json');

$obj = json_decode($res->body());

$sections = [];
$sectionsIndex = -1;

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
                    elseif($item->typ == "NZ" && $item->level == 2)
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
                                if(($obj->stru->$piece->level == 3 || $obj->stru->$piece->level == 4) && ($obj->stru->$piece->typ == "ST")){

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
echo "<pre>";
print_r($sections);
echo "</pre>";
echo "<br><br><br>";
echo "<pre>";
print_r($obj);
echo "</pre>";
