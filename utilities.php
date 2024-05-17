<?php
function get_product_by_sku($sku)
{

    global $wpdb;

    $product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku));

    if ($product_id) {
        return new WC_Product($product_id);
    } else {

        return null;
    }
}

// add categories function
function addProductCategories($categories)
{
    $categoriesArray = explode(",", $categories);
    $categoriesResult = array();

    for ($i = 0; $i < count($categoriesArray); $i++) {
        $catArray = explode('>', $categoriesArray[$i]);
        for ($k = 0; $k < count($catArray); $k++) {
            $finalcategories = array();
            $catName = trim($catArray[$k]);
            $finalcategories['name'] =  $catName;
            if ($k > 0) {
                $catName = trim($catArray[$k - 1]);
                $finalcategories['parent'] = getCategoryId($catName);
            }

            $categotyObject = json_encode($finalcategories, false);

            // add category
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => NF_API_URL . '/products/categories',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $categotyObject,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $responseData = json_decode($response, true);
            if (!empty($responseData) && is_array($responseData)) {
                // check category already exists           
                if (array_key_exists('code', $responseData)) {
                    if ($responseData['code'] == "term_exists") {
                        $categoriesResult[]['id'] = array_key_exists('data', $responseData) ? $responseData['data']['resource_id'] : null;
                    }
                } else {
                    if (array_key_exists('id', $responseData)) {
                        $categoriesResult[]['id'] = $responseData['id'];
                    }
                }
            }
        }
    }
    return $categoriesResult;
}

function getCategoryId($category)
{
    $categoriesResult = array();
    $categoies['name'] = $category;
    $categotyObject = json_encode($categoies, false);
    // add category
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => NF_API_URL . '/products/categories',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $categotyObject,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $responseData = json_decode($response, true);
    if (!empty($responseData) && is_array($responseData)) {
        // check category already exists           
        if (array_key_exists('code', $responseData)) {
            if ($responseData['code'] == "term_exists") {
                $categoriesResult = array_key_exists('data', $responseData) ? $responseData['data']['resource_id'] : null;
            }
        } else {
            if (array_key_exists('id', $responseData)) {
                $categoriesResult = $responseData['id'];
            }
        }
    }
    return $categoriesResult;
}
