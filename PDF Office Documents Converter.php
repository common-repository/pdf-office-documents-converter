<?php
/*
Plugin Name: PDF Office Documents Converter
Plugin URI: https://vvpdf.com/pdf-convert-tools-for-wordpress-plugin/
Description: PDF Convert Tools is convert PDF documents and office documents wordpress plugin. Convert PDF To Word/Ppt/Excel ,and also Convert  Word/Ppt/Excel to Pdf.
Version: 1.0.0
Author: xingmiao
Author URI: https://vvpdf.com
License: GPL v2 or later
License URI:https://www.gnu.org/licenses/gpl-2.0.html
*/
// New plugin Summary page class
class vvpdf_wp_plugin_PageTemplater {
    private static $instance;
    protected $templates;
    public static function get_instance() {
           if ( null == self::$instance ) {
                  self::$instance = new vvpdf_wp_plugin_PageTemplater();
           }
           return self::$instance;
    }
    private function __construct() {
           $this->templates = array();
           if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
                  add_filter(
                         'page_attributes_dropdown_pages_args',
                         array( $this, 'register_project_templates' )
                  );
           } else {
                  add_filter(
                         'theme_page_templates', array( $this, 'add_new_template' )
                  );
           }
           add_filter(
                  'wp_insert_post_data',
                  array( $this, 'register_project_templates' )
           );
           add_filter(
                  'template_include',
                  array( $this, 'view_project_template')
           );
           $this->templates = array(
                  'page_new.php' => 'VVPDF首页',
           );
    }
    public function add_new_template( $posts_templates ) {
           $posts_templates = array_merge( $posts_templates, $this->templates );
           return $posts_templates;
    }
    public function register_project_templates( $atts ) {
           $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
           $templates = wp_get_theme()->get_page_templates();
           if ( empty( $templates ) ) {
                  $templates = array();
           }
           wp_cache_delete( $cache_key , 'themes');
           $templates = array_merge( $templates, $this->templates );
           wp_cache_add( $cache_key, $templates, 'themes', 1800 );
           return $atts;
    }
    public function view_project_template( $template ) {
           global $post;
           if ( ! $post ) {
                  return $template;
           }
           if ( ! isset( $this->templates[get_post_meta(
                         $post->ID, '_wp_page_template', true
                  )] ) ) {
                  return $template;
           }
           $file = plugin_dir_path( __FILE__ ). get_post_meta(
                         $post->ID, '_wp_page_template', true
                  );
           if ( file_exists( $file ) ) {
                  return $file;
           } else {
                  echo $file;
           }
           return $template;
    }
}
//Add new Summary Page ,save admin new page create time 
add_action( 'init', array( 'vvpdf_wp_plugin_PageTemplater', 'get_instance' ) ); 

/*Key Functions ,pdf Convert tools*/
function vvpdf_wp_plugin_page_insert_pdftoword(){
    # code...
   
    $content2= '<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <h1>PDF To WORD</h1>
    <div class="dropzone" id="myAwesomeDropzone"></div>
    <div>
    
                    <input id="uploadbut" type="button" value="Start Convert " class="btn btn-success">
    
    </div>
    <div id="pgDiv">
    <h3>Converting ( About 1 minute to done)</h3>
    <progress max="100" value="0" id="pg"></progress></div>
    <div>
    <h1>Convert Result</h1>
    <div id="view"></div>
    </div>
    </div>
    <div class="col-md-2"></div>
    </div>
    <script id="demo" type="text/html"></p>
    <table class="layui-table">
    <colgroup>
    <col width="250">
    <col width="250">
    <col>
           </colgroup>
    <thead>
    <tr>
    <th>Original file name</th>
    <th>Uploaded file time</th>
    <th>Result File download Link(Click to download)</th>
    </tr>
    </thead>
    <tbody>{{#  layui.each(d.list, function(index, item){}}</p>
    <tr>
    <td><span>{{ item.reusltItemFilename }}</span></td>
    <td><span>{{ item.resultItemTime  }}</span></td>
    <td><a href="{{item.reusltItemLink }}">Download Link<span></span></a></td>
    </tr>
    <p>{{#});}}{{#  if(d.list.length === 0){ }}No data{{#  } }}</tbody>
    </table>
    <p></script>';
    $my_post = array(
        'post_title'    => 'PDF To WORD',
        'post_type'     => 'page',
        'post_name'     => 'pdftoword',
        'post_content'  => $content2,
        'post_status'   => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_author' => 1,
        'menu_order' => 0
      );
       $post_result =wp_insert_post( $my_post );
       update_option("vvpdf_vvpdf_wp_plugin_page_insert_pdftoword_result",$post_result);

}
//
function vvpdf_wp_plugin_page_insert_pdftoppt(){
    # code...
   
    $content2= '<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <h1>PDF To PPT</h1>
    <div class="dropzone" id="myAwesomeDropzone"></div>
    <div>
    
                    <input id="uploadbut" type="button" value="Start Convert " class="btn btn-success">
    
    </div>
    <div id="pgDiv">
    <h3>Converting ( About 1 minute to done)</h3>
    <progress max="100" value="0" id="pg"></progress></div>
    <div>
    <h1>Convert Result</h1>
    <div id="view"></div>
    </div>
    </div>
    <div class="col-md-2"></div>
    </div>
    <script id="demo" type="text/html"></p>
    <table class="layui-table">
    <colgroup>
    <col width="250">
    <col width="250">
    <col>
           </colgroup>
    <thead>
    <tr>
    <th>Original file name</th>
    <th>Uploaded file time</th>
    <th>Result File download Link(Click to download)</th>
    </tr>
    </thead>
    <tbody>{{#  layui.each(d.list, function(index, item){}}</p>
    <tr>
    <td><span>{{ item.reusltItemFilename }}</span></td>
    <td><span>{{ item.resultItemTime  }}</span></td>
    <td><a href="{{item.reusltItemLink }}">Download Link<span></span></a></td>
    </tr>
    <p>{{#});}}{{#  if(d.list.length === 0){ }}No data{{#  } }}</tbody>
    </table>
    <p></script>';
    $my_post = array(
        'post_title'    => 'PDF To PPT',
        'post_type'     => 'page',
        'post_name'     => 'pdftoppt',
        'post_content'  => $content2,
        'post_status'   => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_author' => 1,
        'menu_order' => 0
      );

       $post_result =wp_insert_post( $my_post );
       update_option("vvpdf_vvpdf_wp_plugin_page_insert_pdftoppt_result",$post_result);

}
function vvpdf_wp_plugin_page_insert_pdftoexcel(){
    # code...
   
    $content2= '<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <h1>PDF To EXCEL</h1>
    <div class="dropzone" id="myAwesomeDropzone"></div>
    <div>
    
                    <input id="uploadbut" type="button" value="Start Convert " class="btn btn-success">
    
    </div>
    <div id="pgDiv">
    <h3>Converting ( About 1 minute to done)</h3>
    <progress max="100" value="0" id="pg"></progress></div>
    <div>
    <h1>Convert Result</h1>
    <div id="view"></div>
    </div>
    </div>
    <div class="col-md-2"></div>
    </div>
    <script id="demo" type="text/html"></p>
    <table class="layui-table">
    <colgroup>
    <col width="250">
    <col width="250">
    <col>
           </colgroup>
    <thead>
    <tr>
    <th>Original file name</th>
    <th>Uploaded file time</th>
    <th>Result File download Link(Click to download)</th>
    </tr>
    </thead>
    <tbody>{{#  layui.each(d.list, function(index, item){}}</p>
    <tr>
    <td><span>{{ item.reusltItemFilename }}</span></td>
    <td><span>{{ item.resultItemTime  }}</span></td>
    <td><a href="{{item.reusltItemLink }}">Download Link<span></span></a></td>
    </tr>
    <p>{{#});}}{{#  if(d.list.length === 0){ }}No data{{#  } }}</tbody>
    </table>
    <p></script>';
    $my_post = array(
        'post_title'    => 'PDF TO EXCEL',
        'post_type'     => 'page',
        'post_name'     => 'pdftoexcel',
        'post_content'  => $content2,
        'post_status'   => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_author' => 1,
        'menu_order' => 0
      );

       $post_result =wp_insert_post( $my_post );
       update_option("vvpdf_vvpdf_wp_plugin_page_insert_pdftoexcel_result",$post_result);

}
function vvpdf_wp_plugin_page_insert_wordtopdf(){
    # code...
   
    $content2= '<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <h1>WORD TO PDF</h1>
    <div class="dropzone" id="myAwesomeDropzone"></div>
    <div>
    
                    <input id="uploadbut" type="button" value="Start Convert " class="btn btn-success">
    
    </div>
    <div id="pgDiv">
    <h3>Converting ( About 1 minute to done)</h3>
    <progress max="100" value="0" id="pg"></progress></div>
    <div>
    <h1>Convert Result</h1>
    <div id="view"></div>
    </div>
    </div>
    <div class="col-md-2"></div>
    </div>
    <script id="demo" type="text/html"></p>
    <table class="layui-table">
    <colgroup>
    <col width="250">
    <col width="250">
    <col>
           </colgroup>
    <thead>
    <tr>
    <th>Original file name</th>
    <th>Uploaded file time</th>
    <th>Result File download Link(Click to download)</th>
    </tr>
    </thead>
    <tbody>{{#  layui.each(d.list, function(index, item){}}</p>
    <tr>
    <td><span>{{ item.reusltItemFilename }}</span></td>
    <td><span>{{ item.resultItemTime  }}</span></td>
    <td><a href="{{item.reusltItemLink }}">Download Link<span></span></a></td>
    </tr>
    <p>{{#});}}{{#  if(d.list.length === 0){ }}No data{{#  } }}</tbody>
    </table>
    <p></script>';
    $my_post = array(
        'post_title'    => 'WORD TO PDF',
        'post_type'     => 'page',
        'post_name'     => 'wordtopdf',
        'post_content'  => $content2,
        'post_status'   => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_author' => 1,
        'menu_order' => 0
      );

       $post_result =wp_insert_post( $my_post );

       update_option("vvpdf_vvpdf_wp_plugin_page_insert_wordtopdf_result",$post_result);

}
function vvpdf_wp_plugin_page_insert_ppttopdf(){
    # code...
   
    $content2= '<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <h1>PPT TO PDF</h1>
    <div class="dropzone" id="myAwesomeDropzone"></div>
    <div>
    
                    <input id="uploadbut" type="button" value="Start Convert " class="btn btn-success">
    
    </div>
    <div id="pgDiv">
    <h3>Converting ( About 1 minute to done)</h3>
    <progress max="100" value="0" id="pg"></progress></div>
    <div>
    <h1>Convert Result</h1>
    <div id="view"></div>
    </div>
    </div>
    <div class="col-md-2"></div>
    </div>
    <script id="demo" type="text/html"></p>
    <table class="layui-table">
    <colgroup>
    <col width="250">
    <col width="250">
    <col>
           </colgroup>
    <thead>
    <tr>
    <th>Original file name</th>
    <th>Uploaded file time</th>
    <th>Result File download Link(Click to download)</th>
    </tr>
    </thead>
    <tbody>{{#  layui.each(d.list, function(index, item){}}</p>
    <tr>
    <td><span>{{ item.reusltItemFilename }}</span></td>
    <td><span>{{ item.resultItemTime  }}</span></td>
    <td><a href="{{item.reusltItemLink }}">Download Link<span></span></a></td>
    </tr>
    <p>{{#});}}{{#  if(d.list.length === 0){ }}No data{{#  } }}</tbody>
    </table>
    <p></script>';
    $my_post = array(
        'post_title'    => 'PPT TO PDF',
        'post_type'     => 'page',
        'post_name'     => 'ppttopdf',
        'post_content'  => $content2,
        'post_status'   => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_author' => 1,
        'menu_order' => 0
      );

       $post_result =wp_insert_post( $my_post );

       update_option("vvpdf_vvpdf_wp_plugin_page_insert_ppttopdf_result",$post_result);

}
function vvpdf_wp_plugin_page_insert_exceltopdf(){
    # code...
   
    $content2= '<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <h1>EXCEL TO PDF</h1>
    <div class="dropzone" id="myAwesomeDropzone"></div>
    <div>
    
                    <input id="uploadbut" type="button" value="Start Convert " class="btn btn-success">
    
    </div>
    <div id="pgDiv">
    <h3>Converting ( About 1 minute to done)</h3>
    <progress max="100" value="0" id="pg"></progress></div>
    <div>
    <h1>Convert Result</h1>
    <div id="view"></div>
    </div>
    </div>
    <div class="col-md-2"></div>
    </div>
    <script id="demo" type="text/html"></p>
    <table class="layui-table">
    <colgroup>
    <col width="250">
    <col width="250">
    <col>
           </colgroup>
    <thead>
    <tr>
    <th>Original file name</th>
    <th>Uploaded file time</th>
    <th>Result File download Link(Click to download)</th>
    </tr>
    </thead>
    <tbody>{{#  layui.each(d.list, function(index, item){}}</p>
    <tr>
    <td><span>{{ item.reusltItemFilename }}</span></td>
    <td><span>{{ item.resultItemTime  }}</span></td>
    <td><a href="{{item.reusltItemLink }}">Download Link<span></span></a></td>
    </tr>
    <p>{{#});}}{{#  if(d.list.length === 0){ }}No data{{#  } }}</tbody>
    </table>
    <p></script>';
    $my_post = array(
        'post_title'    => 'EXCEL TO PDF',
        'post_type'     => 'page',
        'post_name'     => 'exceltopdf',
        'post_content'  => $content2,
        'post_status'   => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_author' => 1,
        'menu_order' => 0
      );

       $post_result =wp_insert_post( $my_post );

       update_option("vvpdf_vvpdf_wp_plugin_page_insert_exceltopdf_result",$post_result);

}
function vvpdf_wp_plugin_page_insert_pdftojpg(){
    # code...
   
    $content2= '<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <h1>PDF TO JPG</h1>
    <div class="dropzone" id="myAwesomeDropzone"></div>
    <div>
    
                    <input id="uploadbut" type="button" value="Start Convert " class="btn btn-success">
    
    </div>
    <div id="pgDiv">
    <h3>Converting ( About 1 minute to done)</h3>
    <progress max="100" value="0" id="pg"></progress></div>
    <div>
    <h1>Convert Result</h1>
    <div id="view"></div>
    </div>
    </div>
    <div class="col-md-2"></div>
    </div>
    <script id="demo" type="text/html"></p>
    <table class="layui-table">
    <colgroup>
    <col width="250">
    <col width="250">
    <col>
           </colgroup>
    <thead>
    <tr>
    <th>Original file name</th>
    <th>Uploaded file time</th>
    <th>Result File download Link(Click to download)</th>
    </tr>
    </thead>
    <tbody>{{#  layui.each(d.list, function(index, item){}}</p>
    <tr>
    <td><span>{{ item.reusltItemFilename }}</span></td>
    <td><span>{{ item.resultItemTime  }}</span></td>
    <td><a href="{{item.reusltItemLink }}">Download Link<span></span></a></td>
    </tr>
    <p>{{#});}}{{#  if(d.list.length === 0){ }}No data{{#  } }}</tbody>
    </table>
    <p></script>';
    $my_post = array(
        'post_title'    => 'PDF TO JPG',
        'post_type'     => 'page',
        'post_name'     => 'pdftojpg',
        'post_content'  => $content2,
        'post_status'   => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_author' => 1,
        'menu_order' => 0
      );

       $post_result =wp_insert_post( $my_post );

       update_option("vvpdf_vvpdf_wp_plugin_page_insert_pdftojpg_result",$post_result);

}
function vvpdf_wp_plugin_page_insert_index(){
    # code...
   
    $content2= '<div class="">
    <div class="tools__container">
    <div class="tools__item">
                <a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word">
    <div class="tools__item__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                            <path d="M32.324 15.656h-9.547c-2.477 0-3.375.258-4.28.742a5.04 5.04 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.547H5.18c-1.8 0-2.45-.187-3.113-.54-.648-.348-1.184-.88-1.527-1.527-.352-.66-.54-1.31-.54-3.113V5.18c0-1.8.188-2.45.54-3.113S1.4.89 2.066.54 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54.648.344 1.18.88 1.527 1.527.352.66.54 1.313.54 3.113zm0 0" fill-rule="evenodd" fill="rgb(86.27451%,89.803922%,98.039216%)"></path>
                            <path d="M14.477 7.52a.88.88 0 0 0-.883-.867c-.48 0-.883.39-.883.867v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.547c-.488 0-.883.387-.883.863s.398.867.883.867h6.055a.92.92 0 0 0 .336-.066c.215-.086.387-.254.477-.47.05-.102.066-.215.066-.328l.004-5.938zm0 0" fill="rgb(16.078431%,34.117647%,58.431373%)"></path>
                            <path d="M22.855 17.676H44.82c1.8 0 2.45.188 3.113.543a3.68 3.68 0 0 1 1.527 1.523c.352.66.54 1.313.54 3.113V44.82c0 1.8-.187 2.45-.54 3.113s-.867 1.176-1.527 1.527-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54-.648-.344-1.18-.88-1.527-1.527-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0" fill-rule="evenodd" fill="rgb(37.254902%,51.372549%,77.647059%)"></path>
                            <path d="M38.996 26.75h2.965l-2.94 14.64h-3.094l-1.777-9.035-1.824 9.035H29.12L26.2 26.75h3.164l1.508 9.363 1.938-9.363h3.004l1.727 9.297zm0 0" fill="rgb(100%,100%,100%)"></path>
                        </svg></div>
    <h3>PDF to Word</h3>
    <div class="tools__item__content">
    
                        Easily convert your PDF files into easy to edit DOC and DOCX documents. The converted WORD document
    is almost 100% accurate.
    
    </div>
    </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word">            </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoword").'" title="PDF to Word"> </a>
    
    </div>
    <div class="tools__item">
                <a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint">
    <div class="tools__item__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                            <path d="M32.324 15.656h-9.55c-2.477 0-3.375.258-4.28.742a5.06 5.06 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.55H5.18c-1.8 0-2.453-.187-3.113-.54a3.69 3.69 0 0 1-1.527-1.527C.188 29.598 0 28.945 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.69 3.69 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.69 3.69 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0" fill-rule="evenodd" fill="rgb(95.294118%,85.098039%,80%)"></path>
                            <path d="M14.477 7.52c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.55c-.488 0-.883.387-.883.867s.395.863.883.863h6.047a.85.85 0 0 0 .34-.066c.215-.086.387-.254.477-.47.05-.102.066-.215.066-.328l.004-5.934zm0 0" fill="rgb(81.568627%,27.058824%,14.901961%)"></path>
                            <g fill-rule="evenodd">
                                <path d="M22.855 17.676H44.82c1.8 0 2.453.188 3.113.543.648.344 1.184.875 1.527 1.527.352.656.54 1.31.54 3.11V44.82c0 1.8-.187 2.453-.54 3.113a3.69 3.69 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54-.648-.344-1.18-.88-1.527-1.527-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0" fill="rgb(100%,46.27451%,31.764706%)"></path>
                                <path d="M38.367 34.648C37.28 35.55 35.828 36 34.008 36H32.39v5H29V26.5h5.313c3.79 0 5.688 1.54 5.688 4.62 0 1.453-.543 2.633-1.633 3.535zM33.82 29H32.5v4.5h1.32c1.785 0 2.68-.758 2.68-2.273 0-1.484-.89-2.227-2.68-2.227zm0 0" fill="rgb(100%,100%,100%)"></path>
                            </g></svg></div>
    <h3>PDF to Powerpoint</h3>
    <div class="tools__item__content">
    
                        Turn your PDF files into easy to edit PPT and PPTX slideshows.
    
    </div>
    </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint">            </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoppt").'" title="PDF to Powerpoint"> </a>
    
    </div>
    <div class="tools__item">
                <a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel">
    <div class="tools__item__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                            <path d="M32.324 15.656h-9.55c-2.477 0-3.375.258-4.28.742a5.06 5.06 0 0 0-2.098 2.102c-.484.902-.742 1.8-.742 4.277v9.55H5.18c-1.8 0-2.453-.187-3.113-.54a3.69 3.69 0 0 1-1.527-1.527C.188 29.598 0 28.945 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.69 3.69 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54a3.69 3.69 0 0 1 1.527 1.527c.352.66.54 1.313.54 3.113zm0 0" fill-rule="evenodd" fill="rgb(76.078431%,89.803922%,76.470588%)"></path>
                            <path d="M14.477 7.52c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844L7.566 6.316a.89.89 0 0 0-1.246 0c-.168.16-.258.38-.258.61s.1.453.258.613l5.145 5.05H7.55c-.488 0-.883.387-.883.867s.395.863.883.863h6.047a.85.85 0 0 0 .34-.066c.215-.086.387-.254.477-.47.05-.102.066-.215.066-.328l.004-5.934zm0 0" fill="rgb(18.039216%,44.705882%,21.568627%)"></path>
                            <g fill-rule="evenodd">
                                <path d="M22.855 17.676H44.82c1.8 0 2.453.188 3.113.543.648.344 1.184.875 1.527 1.527.352.656.54 1.31.54 3.11V44.82c0 1.8-.187 2.453-.54 3.113a3.69 3.69 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54-.648-.344-1.18-.88-1.527-1.527-.352-.66-.54-1.312-.54-3.113V22.855c0-1.8.188-2.453.54-3.113.348-.648.88-1.18 1.527-1.527.66-.352 1.313-.54 3.113-.54zm0 0" fill="rgb(36.862745%,63.137255%,38.431373%)"></path>
                                <path d="M36.61 41l-2.508-4.72c-.102-.176-.195-.5-.3-.973h-.04c-.047.223-.16.56-.336 1.012L30.9 41H27l4.64-7.25-4.246-7.25h3.992l2.082 4.348c.164.344.313.754.438 1.227h.04c.082-.285.234-.703.457-1.266l2.316-4.31h3.66l-4.37 7.19L40.5 41zm0 0" fill="rgb(100%,100%,100%)"></path>
                            </g></svg></div>
    <h3>PDF to Excel</h3>
    <div class="tools__item__content">
    
                        Pull data straight from PDFs into Excel spreadsheets in a few short seconds.
    
    </div>
    </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel">            </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftoexcel").'" title="PDF to Excel"> </a>
    
    </div>
    <div class="tools__item">
                <a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF">
    <div class="tools__item__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                            <path d="M17.676 34.344h9.55c2.477 0 3.375-.258 4.28-.742a5.04 5.04 0 0 0 2.098-2.102c.484-.902.742-1.8.742-4.277v-9.547H44.82c1.8 0 2.453.188 3.113.54s1.176.87 1.527 1.527.54 1.31.54 3.113V44.82c0 1.8-.187 2.453-.54 3.113a3.69 3.69 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54s-1.172-.87-1.527-1.527-.54-1.312-.54-3.113zm0 0" fill-rule="evenodd" fill="rgb(37.254902%,51.372549%,77.647059%)"></path>
                            <path d="M43.94 37.137c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844l-5.145-5.047c-.348-.34-.902-.34-1.25 0a.85.85 0 0 0-.258.609.86.86 0 0 0 .258.613l5.145 5.05h-3.914c-.488 0-.883.387-.883.867s.395.867.883.867h6.05c.113-.004.227-.023.336-.07a.87.87 0 0 0 .477-.465c.05-.105.066-.22.066-.332l.004-5.934zm0 0" fill="rgb(100%,100%,100%)"></path>
                            <path d="M27.145 32.324H5.18c-1.8 0-2.453-.187-3.113-.543S.89 30.914.54 30.254 0 28.95 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.69 3.69 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54s1.172.87 1.527 1.527.54 1.313.54 3.113v21.965c0 1.8-.187 2.453-.54 3.113s-.87 1.176-1.527 1.527-1.312.54-3.113.54zm0 0" fill-rule="evenodd" fill="rgb(86.27451%,89.803922%,98.039216%)"></path>
                            <path d="M20.844 8.61h2.96l-2.94 14.64H17.77l-1.777-9.035-1.824 9.035h-3.203L8.04 8.61h3.164l1.508 9.363 1.938-9.363h3.004l.04.203 1.688 9.1zm0 0" fill="rgb(16.078431%,34.117647%,58.431373%)"></path>
                        </svg></div>
    <h3>Word to PDF</h3>
    <div class="tools__item__content">
    
                        Make DOC and DOCX files easy to read by converting them to PDF.
    
    </div>
    </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF">            </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("wordtopdf").'" title="Word to PDF"> </a>
    
    </div>
    <div class="tools__item">
                <a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF">
    <div class="tools__item__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                            <path d="M17.676 34.344h9.55c2.476 0 3.375-.258 4.28-.742a5.04 5.04 0 0 0 2.097-2.102c.495-.902.743-1.8.743-4.277v-9.547H44.82c1.8 0 2.453.187 3.114.54.656.355 1.175.87 1.527 1.527s.54 1.31.54 3.113V44.82c0 1.8-.187 2.453-.54 3.114-.35.656-.87 1.175-1.526 1.527S46.62 50 44.82 50H22.855c-1.8 0-2.453-.187-3.113-.54s-1.172-.87-1.527-1.526-.54-1.312-.54-3.113zm0 0" fill-rule="evenodd" fill="rgb(100%,46.27451%,31.764706%)"></path>
                            <path d="M43.94 37.137c0-.477-.393-.864-.88-.864s-.884.387-.884.864v3.843l-5.146-5.046c-.346-.34-.9-.34-1.25 0-.163.16-.257.38-.257.61a.86.86 0 0 0 .258.613l5.145 5.05h-3.914c-.49 0-.882.387-.882.867s.393.867.882.867H43.063c.113-.002.227-.022.335-.07.215-.085.387-.253.477-.464a.75.75 0 0 0 .065-.332l.005-5.934zm0 0" fill="rgb(100%,100%,100%)"></path>
                            <g fill-rule="evenodd">
                                <path d="M27.145 32.324H5.18c-1.8 0-2.453-.187-3.113-.543S.89 30.914.54 30.254 0 28.95 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.69 3.69 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54s1.172.87 1.527 1.527.54 1.313.54 3.113v21.965c0 1.8-.187 2.453-.54 3.113s-.87 1.176-1.527 1.527-1.312.54-3.113.54zm0 0" fill="rgb(95.294118%,85.098039%,80%)"></path>
                                <path d="M19.367 17.156c-1.086.898-2.54 1.348-4.36 1.348H13.39V23.5H10V9h5.313C19.102 9 21 10.54 21 13.62c0 1.453-.543 2.637-1.633 3.535zM14.82 11.5H13.5V16h1.32c1.785 0 2.68-.758 2.68-2.273 0-1.484-.89-2.227-2.68-2.227zm0 0" fill="rgb(81.568627%,27.058824%,14.901961%)"></path>
                            </g></svg></div>
    <h3>Powerpoint to PDF</h3>
    <div class="tools__item__content">
    
                        Make PPT and PPTX slideshows easy to view by converting them to PDF.
    
    </div>
    </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF">            </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF">
    </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("ppttopdf").'" title="Powerpoint to PDF"> </a>
    
    </div>
    <div class="tools__item">
                <a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF">
    <div class="tools__item__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                            <path d="M17.676 34.344h9.55c2.477 0 3.375-.258 4.28-.742a5.04 5.04 0 0 0 2.098-2.102c.484-.902.742-1.8.742-4.277v-9.547H44.82c1.8 0 2.453.188 3.113.54s1.176.87 1.527 1.527.54 1.31.54 3.113V44.82c0 1.8-.187 2.453-.54 3.113a3.69 3.69 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54s-1.172-.87-1.527-1.527-.54-1.312-.54-3.113zm0 0" fill-rule="evenodd" fill="rgb(36.862745%,63.137255%,38.431373%)"></path>
                            <path d="M43.94 37.137c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844l-5.145-5.047c-.348-.34-.902-.34-1.25 0a.85.85 0 0 0-.258.609.86.86 0 0 0 .258.613l5.145 5.05h-3.914c-.488 0-.883.387-.883.867s.395.867.883.867h6.05c.113-.004.227-.023.336-.07a.87.87 0 0 0 .477-.465c.05-.105.066-.22.066-.332l.004-5.934zm0 0" fill="rgb(100%,100%,100%)"></path>
                            <g fill-rule="evenodd">
                                <path d="M27.145 32.324H5.18c-1.8 0-2.453-.187-3.113-.543S.89 30.914.54 30.254 0 28.95 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.69 3.69 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54s1.172.87 1.527 1.527.54 1.313.54 3.113v21.965c0 1.8-.187 2.453-.54 3.113s-.87 1.176-1.527 1.527-1.312.54-3.113.54zm0 0" fill="rgb(76.078431%,89.803922%,76.470588%)"></path>
                                <path d="M19.11 23.5l-2.508-4.72c-.102-.176-.195-.5-.3-.973h-.04c-.047.223-.16.56-.336 1.012L13.4 23.5H9.5l4.64-7.25L9.895 9h3.992l2.082 4.348c.164.344.313.754.438 1.227h.04c.082-.285.234-.703.457-1.266L19.22 9h3.66l-4.37 7.19L23 23.5zm0 0" fill="rgb(18.039216%,44.705882%,21.568627%)"></path>
                            </g></svg></div>
    <h3>Excel to PDF</h3>
    <div class="tools__item__content">
    
                        Make EXCEL spreadsheets easy to read by converting them to PDF.
    
    </div>
    </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF">            </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("exceltopdf").'" title="Excel to PDF"> </a>
    
    </div>
    <div class="tools__item">
                <a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG">
    <div class="tools__item__icon">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                            <path
                                d="M17.676 34.344h9.55c2.477 0 3.375-.258 4.28-.742a5.04 5.04 0 0 0 2.098-2.102c.484-.902.742-1.8.742-4.277v-9.547H44.82c1.8 0 2.453.188 3.113.54s1.176.87 1.527 1.527.54 1.31.54 3.113V44.82c0 1.8-.187 2.453-.54 3.113a3.69 3.69 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54s-1.172-.87-1.527-1.527-.54-1.312-.54-3.113zm0 0"
                                fill-rule="evenodd" fill="rgb(36.862745%,63.137255%,38.431373%)"></path>
                            <path
                                d="M43.94 37.137c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844l-5.145-5.047c-.348-.34-.902-.34-1.25 0a.85.85 0 0 0-.258.609.86.86 0 0 0 .258.613l5.145 5.05h-3.914c-.488 0-.883.387-.883.867s.395.867.883.867h6.05c.113-.004.227-.023.336-.07a.87.87 0 0 0 .477-.465c.05-.105.066-.22.066-.332l.004-5.934zm0 0"
                                fill="rgb(100%,100%,100%)"></path>
                            <g fill-rule="evenodd">
                                <path
                                    d="M27.145 32.324H5.18c-1.8 0-2.453-.187-3.113-.543S.89 30.914.54 30.254 0 28.95 0 27.145V5.18c0-1.8.188-2.453.54-3.113A3.69 3.69 0 0 1 2.066.539C2.727.188 3.38 0 5.18 0h21.965c1.8 0 2.453.188 3.113.54s1.172.87 1.527 1.527.54 1.313.54 3.113v21.965c0 1.8-.187 2.453-.54 3.113s-.87 1.176-1.527 1.527-1.312.54-3.113.54zm0 0"
                                    fill="rgb(76.078431%,89.803922%,76.470588%)"></path>
                                <path
                                    d="M19.11 23.5l-2.508-4.72c-.102-.176-.195-.5-.3-.973h-.04c-.047.223-.16.56-.336 1.012L13.4 23.5H9.5l4.64-7.25L9.895 9h3.992l2.082 4.348c.164.344.313.754.438 1.227h.04c.082-.285.234-.703.457-1.266L19.22 9h3.66l-4.37 7.19L23 23.5zm0 0"
                                    fill="rgb(18.039216%,44.705882%,21.568627%)"></path>
                            </g>
                        </svg> -->
    
    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                            <path d="M17.676 34.344h9.55c2.477 0 3.375-.258 4.28-.742a5.04 5.04 0 0 0 2.098-2.102c.484-.902.742-1.8.742-4.277v-9.547H44.82c1.8 0 2.453.188 3.113.54s1.176.87 1.527 1.527.54 1.31.54 3.113V44.82c0 1.8-.187 2.453-.54 3.113a3.69 3.69 0 0 1-1.527 1.527c-.66.352-1.312.54-3.113.54H22.855c-1.8 0-2.453-.187-3.113-.54s-1.172-.87-1.527-1.527-.54-1.312-.54-3.113zm0 0" fill-rule="evenodd" fill="rgb(98.431373%,93.72549%,65.882353%)"></path>
                            <path d="M43.94 37.137c0-.477-.395-.863-.883-.863s-.883.387-.883.863v3.844l-5.145-5.047c-.348-.34-.902-.34-1.25 0a.85.85 0 0 0-.258.609.86.86 0 0 0 .258.613l5.145 5.05h-3.914c-.488 0-.883.387-.883.867s.395.867.883.867h6.05c.113-.004.227-.023.336-.07a.87.87 0 0 0 .477-.465c.05-.105.066-.22.066-.332l.004-5.934zm0 0" fill="rgb(71.764706%,62.745098%,0.392157%)"></path>
                            <g fill-rule="evenodd">
                                <path d="M5.184 0h21.988c1.8 0 2.453.188 3.113.54.652.344 1.184.88 1.527 1.53.352.656.54 1.313.54 3.113v21.984c0 1.805-.187 2.457-.54 3.117-.344.648-.875 1.184-1.527 1.527-.66.352-1.312.54-3.113.54H5.184c-1.8 0-2.457-.187-3.113-.54-.652-.344-1.184-.88-1.527-1.527C.188 29.625 0 28.973 0 27.168V5.184c0-1.8.188-2.457.54-3.113.344-.652.88-1.184 1.53-1.53S3.383 0 5.184 0zm0 0" fill="rgb(83.921569%,74.901961%,17.647059%)"></path>
                                <path d="M10.28 12.945v4.688c0 1.66-.926 2.66-2.707 2.66C5.406 20.293 5 18.852 5 18.07c0-.668.31-1.098.86-1.098.648 0 .813.504.813 1.05 0 .516.242.89.88.89.594 0 .926-.44.926-1.3V12.95c0-.54.352-.898.902-.898s.902.36.902.898zm1.672 6.402v-6.102c0-.8.418-1.055 1.055-1.055h2.762c1.516 0 2.738.75 2.738 2.508 0 1.44-1 2.508-2.75 2.508h-2v2.152c0 .54-.355.902-.902.902s-.902-.363-.902-.902zm1.805-5.773v2.242h1.68c.727 0 1.266-.437 1.266-1.12 0-.793-.56-1.12-1.45-1.12zm13.285 3.1v2.984c0 .332-.254.602-.613.602-.52 0-.66-.32-.773-1.023-.516.648-1.23 1.066-2.352 1.066-2.793 0-3.863-1.926-3.863-4.145 0-2.676 1.672-4.148 4.125-4.148 2.004 0 3.07 1.2 3.07 1.902 0 .63-.46.793-.848.793-.89 0-.56-1.242-2.32-1.242-1.242 0-2.223.813-2.223 2.816 0 1.56.77 2.637 2.246 2.637.957 0 1.793-.648 1.88-1.617H24.2c-.383 0-.812-.14-.812-.69 0-.44.254-.69.703-.69h2.223c.527 0 .738.262.738.758zm0 0" fill="rgb(100%,100%,100%)"></path>
                            </g></svg>
    
    </div>
    <h3>PDF To JPG</h3>
    <div class="tools__item__content">
    
                        Convert JPG images to PDF in seconds. Easily adjust orientation and margins.
    
    </div>
    </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG">            </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"> </a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"></a><a href="'.vvpdf_wp_plugin_get_url_by_slug("pdftojpg").'" title="PDF To JPG"> </a>
    
    </div>
    </div>
    </div>';
    $my_post = array(
        'post_title'    => 'Index -PDF Convert TOOLS',
        'post_type'     => 'page',
        'post_name'     => 'pdfindex',
        'post_content'  => $content2,
        'post_status'   => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_author' => 1,
        'menu_order' => 0,
        'page_template'  => "page_new.php"

      );
      $post_result =wp_insert_post( $my_post );
    update_option("vvpdf_vvpdf_wp_plugin_page_insert_index_result",$post_result);

}

/*register_activation_hook Functions ,pdf Convert tools*/
register_activation_hook( __FILE__, 'vvpdf_wp_plugin_page_insert_pdftoword' );
register_activation_hook( __FILE__, 'vvpdf_wp_plugin_page_insert_pdftoppt' );
register_activation_hook( __FILE__, 'vvpdf_wp_plugin_page_insert_pdftoexcel' );
register_activation_hook( __FILE__, 'vvpdf_wp_plugin_page_insert_wordtopdf' );
register_activation_hook( __FILE__, 'vvpdf_wp_plugin_page_insert_ppttopdf' );
register_activation_hook( __FILE__, 'vvpdf_wp_plugin_page_insert_exceltopdf' );
register_activation_hook( __FILE__, 'vvpdf_wp_plugin_page_insert_pdftojpg' );
register_activation_hook( __FILE__, 'vvpdf_wp_plugin_page_insert_index' );

/*wp_enqueue_script Functions ,pdf Convert tools*/
function vvpdf_wp_plugin_tone_front_script() {  
    wp_enqueue_script( 'dropzone', plugin_dir_url( __FILE__ ) . 'js/dropzone.js');
    /*判断页面类型*/
    if (is_page('pdftoword')){
        wp_enqueue_script( 'pdftowordtest5', plugin_dir_url( __FILE__ ) . 'js/pdftowordtest5.js');
    }
    if (is_page('pdftoppt')){
        wp_enqueue_script( 'pdftoppttest5', plugin_dir_url( __FILE__ ) . 'js/pdftoppttest5.js');
    }
    if (is_page('pdftoexcel')){
        wp_enqueue_script( 'pdftoexceltest5', plugin_dir_url( __FILE__ ) . 'js/pdftoexceltest5.js');
    }
    if (is_page('wordtopdf')){
        wp_enqueue_script( 'wordtopdftest5', plugin_dir_url( __FILE__ ) . 'js/wordtopdf.js');
    }
    if (is_page('ppttopdf')){
        wp_enqueue_script( 'ppttopdftest5', plugin_dir_url( __FILE__ ) . 'js/ppttopdf.js');
    }
    if (is_page('exceltopdf')){
        wp_enqueue_script( 'exceltopdftest5', plugin_dir_url( __FILE__ ) . 'js/exceltopdf.js');
    }
    if (is_page('pdftojpg')){
        wp_enqueue_script( 'pdftojpgtest5', plugin_dir_url( __FILE__ ) . 'js/pdftoimage.js');
    }
    if (is_page('pdfindex')){
        
        wp_enqueue_style( 'ilovepdf', plugin_dir_url( __FILE__ )  . 'css/ilovepdf.css' );

    }  
    wp_enqueue_script( 'layui.all', plugin_dir_url( __FILE__ ) . 'js/layui.all.js');
    wp_enqueue_style( 'dropzone', plugin_dir_url( __FILE__ ) . 'css/dropzone.css' );
    wp_enqueue_style( 'layui', plugin_dir_url( __FILE__ )  . 'css/layui.css' );
 }

 add_action( 'wp_enqueue_scripts', 'vvpdf_wp_plugin_tone_front_script' );


 function vvpdf_wp_plugin_get_url_by_slug($slug) {
    $page_url_id = get_page_by_path( $slug );
    $page_url_link = get_permalink($page_url_id);
    return $page_url_link;
}

#Add menu
add_action('admin_menu','vvpdf_wp_plugin_add_settings_menu');
function vvpdf_wp_plugin_add_settings_menu() {
    add_menu_page(__('PDF Converter'), __('PDF Converter'), 'administrator',  __FILE__, 'vvpdf_wp_plugin_my_function_menu', false, 100);
    add_submenu_page(__FILE__,'Created Pages','Created Pages', 'administrator', 'your-admin-sub-menu1', 'vvpdf_wp_plugin_my_function_submenu1');

}
function vvpdf_wp_plugin_my_function_menu() {
  echo "<h2> Intro:</h2>";
  echo "<h2>PDF Convert Tools is convert PDF documents and office documents wordpress plugin online. <h2>

  <h3>The specific functions are as follows:</h3>
  
  <p>
  <h4>pdf to word</h4>
  <h4>pdf to powerpoint</h4>
  <h4>pdf to excel</h4>
  <h4>word to pdf</h4>
  <h4>powerpoint to pdf</h4>
  <h4>pdf to jpg</h4>
  </p>
  
  <h3>Functional limitations:</h3>
  
  <P>
  <h4>Single file less than 2M</h4>
  <h4>Process up to 5 documents at a time</h4>
  <h4>Unlimited total number of conversions</h4>
  </P>
  
  <h3>Live Demo:</h3>
  
  <P>
  <h4><a href='https://vvpdf.com' target='_blank'>vvpdf.com</a></h4>
  <h3>Powered by vvpdf.com</h3>
  </P>";
}
function vvpdf_wp_plugin_my_function_submenu1() {
    echo "<h2>PDF CONVERT TOOLS Auto Created Pages List:</h2></br>";
    echo "<h3> pdftoword page:   ". vvpdf_wp_plugin_get_url_by_slug("pdftoword")."</h3></br>";
    echo "<h3> pdftoppt page:   ". vvpdf_wp_plugin_get_url_by_slug("pdftoppt")."</h3></br>";
    echo "<h3> pdftoexcel page:   ".vvpdf_wp_plugin_get_url_by_slug("pdftoexcel")."</h3></br>";
    echo "<h3> wordtopdf page:   ". vvpdf_wp_plugin_get_url_by_slug("wordtopdf")."</h3></br>";
    echo "<h3> ppttopdf page:   ". vvpdf_wp_plugin_get_url_by_slug("ppttopdf")."</h3></br>";
    echo "<h3> exceltopdf page:   ". vvpdf_wp_plugin_get_url_by_slug("exceltopdf")."</h3></br>";
    echo "<h3> pdftojpg page:   ". vvpdf_wp_plugin_get_url_by_slug("pdftojpg")."</h3></br>";
    echo "<h3> pdfindex page:   ". vvpdf_wp_plugin_get_url_by_slug("pdfindex")."</h3></br>";
    echo "The pdfindex page Is the summary navigation page of all autocreated pages , you can modify as you need ";

}

