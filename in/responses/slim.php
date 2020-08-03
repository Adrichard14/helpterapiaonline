<?php
    require_once('../../lib/classes/Package.php');
    new Package();
    if(!User::restrict(false, false)) {
        Slim::outputJSON(array(
            'status' => SlimStatus::FAILURE,
            'message' => 'Acesso negado.'
        ));
        exit();
    }
    $images = Slim::getImages();

    if($images === false) {

        // Possible solutions
        // ----------
        // Make sure the name of the file input is "slim[]" or you have passed your custom
        // name to the getImages method above like this -> Slim::getImages("myFieldName")

        Slim::outputJSON(array(
            'status' => SlimStatus::FAILURE,
            'message' => 'Nenhum dado foi enviado.'
        ));

        exit();
    }

    // Should always be one image (when posting async), so we'll use the first on in the array (if available)
    $image = array_shift($images);


    // Something was posted but no images were found
    if(!isset($image)) {

        // Possible solutions
        // ----------
        // Make sure you're running PHP version 5.6 or higher

        Slim::outputJSON(array(
            'status' => SlimStatus::FAILURE,
            'message' => 'Nenhuma imagem encontrada.'
        ));
        exit();
    }

    // If image found but no output or input data present
    if (!isset($image['output']['data']) && !isset($image['input']['data'])) {
        // Possible solutions
        // ----------
        // If you've set the data-post attribute make sure it contains the "output" value -> data-post="actions,output"
        // If you want to use the input data and have set the data-post attribute to include "input", replace the 'output' String above with 'input'

        Slim::outputJSON(array(
            'status' => SlimStatus::FAILURE,
            'message' => 'A imagem não possui dados.'
        ));
        exit();
    }



    // if we've received output data save as file
    if (isset($image['output']['data'])) {

        // get the name of the file
        $name = $image['output']['name'];

        // get the crop data for the output image
        $data = $image['output']['data'];

        // If you want to store the file in another directory pass the directory name as the third parameter.
        // $file = Slim::saveFile($data, $name, 'my-directory/');

        // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
        // $file = Slim::saveFile($data, $name, 'tmp/', false);
        $output = Slim::saveFile($data, $name);
    }

    // if we've received input data (do the same as above but for input data)
    if (isset($image['input']['data'])) {

        // get the name of the file
        $name = $image['input']['name'];

        // get the crop data for the output image
        $data = $image['input']['data'];

        // If you want to store the file in another directory pass the directory name as the third parameter.
        // $file = Slim::saveFile($data, $name, 'my-directory/');

        // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
        // $file = Slim::saveFile($data, $name, 'tmp/', false);
        $input = Slim::saveFile($data, $name);

    }



    //
    // Build response to client
    //
    $response = array(
        'status' => SlimStatus::SUCCESS
    );

    if (isset($output) && isset($input)) {

        $response['output'] = array(
            'file' => $output['name'],
            'path' => $output['path']
        );

        $response['input'] = array(
            'file' => $input['name'],
            'path' => $input['path']
        );

    }
    else {
        $response['file'] = isset($output) ? $output['name'] : $input['name'];
        $response['path'] = isset($output) ? $output['path'] : $input['path'];
    }

    // Return results as JSON String
    Slim::outputJSON($response);