<?php

namespace AST\Plugin\SEO;

class MetaInfo extends \AST\TagParser{

    /**
     * Static instance of self
     *
     * @var MetaInfo
     */
    protected static $instance;

    protected $rss;
    protected $default_title = "%seotitle% %sep% %sitename%";
    protected $default_des = "%seodes%";
    protected $default_keywords = "%seokeywords%";
    
    public $seo_title = "";
    public $seo_link = "";
    public $seo_des = "";
    public $robotindex = true;
    public $seo_keywords = "";
    public $featured_image = "";
    public $updated_time = "";

    public function __construct(){
        $this->rss = get_site_url("feed/");
        parent::__construct();
        $this->default_tags[] = "%seotitle%";
        $this->default_tags[] = "%seodes%";
        $this->default_tags[] = "%seokeywords%";
    }

    public function generate(){

        $this->seo_title = apply_filters("tkp/seo/title", $this->seo_title);
        $this->seo_link = apply_filters("tkp/seo/link", $this->seo_link);
        $this->seo_des = apply_filters("tkp/seo/description", $this->seo_des);
        $this->robotindex = apply_filters("tkp/seo/index", $this->robotindex);
        $this->seo_keywords = apply_filters("tkp/seo/keywords", $this->seo_keywords);
        $this->featured_image = apply_filters("tkp/seo/image", $this->featured_image);
        $this->updated_time = apply_filters("tkp/seo/updated", $this->updated_time);

        $metags = '';
        if( !empty( $this->seo_title ) ){
            $metags .= sprintf('    <title>%s</title>', @$this->seo_title) . PHP_EOL;
        }
        
        if( $this->robotindex ){
            $metags .= '    <meta name="robots" content="index,follow">' . PHP_EOL . PHP_EOL;
        }else{
            $metags .= '    <meta name="robots" content="noindex,nofollow">' . PHP_EOL . PHP_EOL;
        }
    
        $facebooktags = '    <meta property="og:type" content="website">' . PHP_EOL;
        $facebooktags .= '    <meta property="og:locale" content="en_US">' . PHP_EOL;
        $twittertags = '    <meta name="twitter:card" content="summary_large_image">' . PHP_EOL;
    
        $seoURL = @$this->seo_link;
        if( ! empty( $seoURL ) ){
            $metags .= sprintf('    <link rel="canonical" href="%s">', $seoURL) . PHP_EOL;
            if( isset( $_GET['page'] ) && !empty( $_GET['page'] ) ){
                $metags .= sprintf('    <link rel="alternative" href="%s">', get_full_url(true)) . PHP_EOL;
            }
        }
        
        $facebooktags .= sprintf('    <meta name="og:url" content="%s">', @$this->seo_link) . PHP_EOL;
        $twittertags .= sprintf('    <meta name="twitter:url" content="%s">', @$this->seo_link) . PHP_EOL;
        
        if( !empty( @$this->seo_title ) ){
            $metags .= sprintf('    <meta name="title" content="%s">', $this->seo_title) . PHP_EOL;
            $facebooktags .= sprintf('    <meta name="og:title" content="%s">', $this->seo_title) . PHP_EOL;
            $twittertags .= sprintf('    <meta name="twitter:title" content="%s">', $this->seo_title) . PHP_EOL;
        }
    
        if( !empty( @$this->seo_des ) ){
            $metags .= sprintf('    <meta name="description" content="%s">', $this->seo_des) . PHP_EOL;
            $facebooktags .= sprintf('    <meta name="og:description" content="%s">', $this->seo_des) . PHP_EOL;
            $twittertags .= sprintf('    <meta name="twitter:description" content="%s">', $this->seo_des) . PHP_EOL;
        }

        if( ! empty( @$this->seo_keywords ) ){
            $metags .= sprintf('    <meta name="keywords" content="%s">', $this->seo_keywords) . PHP_EOL;
        }
    
        if( !empty( @$this->featured_image ) ){
            $facebooktags .= sprintf('    <meta name="og:image" content="%s">', $this->featured_image) . PHP_EOL;
            $twittertags .= sprintf('    <meta name="twitter:image" content="%s">', $this->featured_image) . PHP_EOL;
        }

        $facebooktags .= sprintf('    <meta name="og:site_name" content="%s">', @$this->parse_sitename()) . PHP_EOL;
        if( !empty( @$this->updated_time ) ){
            $facebooktags .= sprintf('    <meta name="og:updated_time" content="%s">', $this->updated_time) . PHP_EOL;
        }

        $rssTag = '';
        if( $this->rss ){
            $rssTag = PHP_EOL . sprintf('<link rel="alternate" type="application/rss+xml" title="%s" href="%s">', @$this->settings->name, $this->rss) . PHP_EOL . PHP_EOL;
        }

        $metags = apply_filters("tkp/seo/meta/tags", $metags, $this);
        $facebooktags = apply_filters("tkp/seo/facebook/tags", $facebooktags, $this);
        $twittertags = apply_filters("tkp/seo/twitter/tags", $twittertags, $this);

        return sprintf(
            '<!--Primary Tags-->%s    <!-- Open Graph / Facebook -->%s    <!-- Twitter -->%s',
            PHP_EOL . $metags . PHP_EOL . PHP_EOL,
            PHP_EOL . $facebooktags . PHP_EOL . PHP_EOL,
            PHP_EOL . $twittertags . PHP_EOL . PHP_EOL . $rssTag 
        );
    }

    private function get_meta_info($type, $id){
        $seo_title = get_meta($type, $id, "seo_title", $this->default_title);
        $seo_des = get_meta($type, $id, "seo_des", $this->default_des);
        $seo_keywords = get_meta($type, $id, "seo_keywords", $this->default_keywords);
        $index = get_meta($type, $id, "robotindex", true);
        
        return (object) array(
            "seo_title" => $seo_title,
            "seo_des" => $seo_des,
            "seo_keywords" => $seo_keywords,
            "robotindex" => filter_var($index, FILTER_VALIDATE_BOOLEAN)
        );
    }

    protected function parse_seotitle( $type, $data ){
        switch( $type ){
            case "tool":
            case "page":
            case "post":
            case "article":
            case "category":
                if( $data && property_exists( $data, "title" ) )
                    return $data->title;
        }

        return false;
    }

    protected function parse_seodes( $type, $data ){
        
        $description = '';
        switch( $type ){
            case "tool":
            case "page":
            case "post":
            case "article":
            case "category":
                if( $data && property_exists( $data, "description" ) ){
                    $description = $data->description;
                }
                break;
        }

        if( strlen($description) > 160 ){
            $description = ast_trim_characters($description, 160);
            $description = preg_replace("/\s+/", " ", $description);
        }

        return $description;
    }

    private function cleanStopWords($text){
        $commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');
        return preg_replace('/\b('.implode('|',$commonWords).')\b/','',$text);
    }

    protected function parse_seokeywords( $type, $data ){
        $keywords = $this->seo_des;
        if( !empty($keywords) ){
            $keywords = preg_replace("/\s+/", " ", $this->cleanStopWords(strtolower($keywords)));
            $keywords = preg_replace("/\s+/", ",", $keywords);
            $keywords = preg_replace("/,+/", ",", $keywords);
            $keywords = str_replace(array("(", ")", "."), "", $keywords);
            $keywords = rtrim($keywords, ",");
            $keywords = ltrim($keywords, ",");
        }

        return $keywords;
    }

    public function category( $data ){
        if( is_array( $data ) ){
            $data = (object) $data;
        }

        if( $data && property_exists($data, "id") ){
            
            $this->type = "category";
            $this->data = $data;

            $this->seo_link = get_category_url("slug", $data->slug, $data->cat_of);
            $metainfo = $this->get_meta_info( "category", $data->id );
            $this->seo_title = $this->parse($metainfo->seo_title);
            $this->seo_des = $this->parse($metainfo->seo_des);
            $this->seo_keywords = $this->parse($metainfo->seo_keywords);
            $this->robotindex = $metainfo->robotindex;
        }
        return $this;
    }

    public function front( ){
        if( ! empty( @$this->settings ) && property_exists( @$this->settings, "title" ) ){
            $this->seo_title = @$this->settings->title;
            $this->seo_des = @$this->settings->description;
            $this->seo_keywords = @$this->settings->keywords;

            $this->featured_image = @@$this->settings->feature_image;
            $this->updated_time = date("c");
            $this->seo_link = get_site_url();
        }

        return $this;
    }

    public function custom($data){
        if( $data && property_exists($data, "title") ){
            $this->type = "custom";
            $this->data = $data;

            $this->seo_link = $data->link;
            $this->featured_image = @$this->settings->feature_image;
            $this->seo_title = $this->parse($data->title);
            $this->seo_des = $this->parse($data->description);

            if( property_exists($data, "index") ){
                $this->robotindex = filter_var($data->index, FILTER_VALIDATE_BOOLEAN);
            }
        }

        return $this;
    }

    public function post( $type = "page", $data = false ){
        if( $data && property_exists($data, "id") ){
            global $extraparams;
            
            $this->type = $type;
            $this->data = $data;

            if( $type == 'tool' ){
                $this->seo_link = get_tool_url("slug", $data->slug);
            }

            $this->featured_image = get_meta($type, $data->id, "featured_image", $this->default_title);
            if( empty($this->featured_image) ){
                $this->featured_image = @$this->settings->feature_image;
            }

            $this->updated_time = date("c", strtotime($data->modified));

            $metainfo = $this->get_meta_info( $type, $data->id );
            $this->seo_title = $this->parse($metainfo->seo_title);
            $this->seo_des = $this->parse($metainfo->seo_des);
            $this->seo_keywords = $this->parse($metainfo->seo_keywords);
            $this->robotindex = $metainfo->robotindex;
        }
        return $this;
    }

    /**
	 * Main Language Instance.
	 * Insures that only one instance of Language exists in memory at any one time.
	 *
	 * @static
     * @since 1.0.0
	 * @return Language
	 **/
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

}