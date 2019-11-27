<?php
//require_once('../../../../wp-blog-header.php');
require_once (__DIR__ . './../../../../wp-blog-header.php');
//require('../../wp-load.php');
//echo esc_html("削除します");

$name_index = 0;
$lng_index = 3;
$lat_index = 2;
$file_path = "/data.csv";
$post_on = false;
$delete_on = false;
if($delete_on){
    for($i=1;$i<10;$i++){
        $param = array(
        'posts_per_page' => '100'
        );
        $the_query = new WP_Query( $param );
        // ループで投稿を削除
        while ( $the_query->have_posts() ) : $the_query->the_post();
        wp_delete_post( $post->ID , true);
        endwhile;
    }
}

if($post_on){
    $file = new SplFileObject(dirname(__FILE__) . $file_path);
    $file->setFlags(SplFileObject::READ_CSV);
    foreach ($file as $line) {
        $records[] = $line;
    }

    for ($i=1 ; $i<count($records);$i++){
        if($records[$i][$name_index] == null){
           continue;
        }
        //var_dump($records[$i][$name_index]);
        $post_value = array(
            'post_title' => $records[$i][$name_index], //post title
            'post_content' => '[cft format=0]', //post conten
            'tags_input' => ['spot']
        );

        $insert_id = wp_insert_post($post_value);

        if( $insert_id != 0 ){
            update_post_meta($insert_id, 'name',$records[$i][$name_index]);
            update_post_meta($insert_id, 'lng',$records[$i][$lng_index] == null ? 0 : $records[$i][2]);
            update_post_meta($insert_id, 'lat',$records[$i][$lat_index] == null ? 0 : $records[$i][3]);
            //var_dump('Successfully Uploaded!');
        }
        else{
            //var_dump('Error. Insert Id was Zero.');
        }
    }
}



?>