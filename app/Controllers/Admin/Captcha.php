<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Captcha extends Controller
{
    public function generate()
    {
        // Start output buffering
        ob_start();

        // Get the session object
        $session = session();

        // Generate a random CAPTCHA code
        $captcha_code = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 5);
        $session->set('captcha_code', $captcha_code); // Store in session

        // Create the image
        $imageWidth = 120; // Image width
        $imageHeight = 40; // Image height
        $image = imagecreate($imageWidth, $imageHeight);
        if (!$image) {
            die('Failed to create image');
        }

        // Set colors
        $bg_color = imagecolorallocate($image, 255, 255, 255); // White background

        // Add text to the image
        $fontPath = FCPATH . 'assets/dist/font/static/Roboto-Bold.ttf'; // Change to your font file path

        $x = 10;
        $characters = str_split($captcha_code);
        $totalWidth = 0;
        $fontSize =18;
        // Calculate the total width of the text
        foreach ($characters as $char) {
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $char); // Calculate bounding box
            $totalWidth += abs($bbox[2] - $bbox[0]); // Add width of each character
        }

        // Add spacing between characters
        $spacing = 9;
        $totalWidth += ($spacing * (count($characters) - 1)); // Add spacing for all characters except the last

        // Calculate starting x position to center the text
        $x = ($imageWidth - $totalWidth) / 2;

        foreach ($characters as $char) {
            // Generate a random angle for rotation between -30 and 30 degrees
            $angle = rand(-15, 15);
            $text_color = imagecolorallocate($image, rand(0,150), rand(0,150), rand(0,150)); // Random color text

            // Calculate the bounding box for the character with the current rotation
            $bbox = imagettfbbox($fontSize, $angle, $fontPath, $char);
            $charWidth = abs($bbox[2] - $bbox[0]); // Width of the character

            // Check if the next character will fit within the image width
            if ($x + $charWidth > $imageWidth - 10) { // Leave some padding
                break; // Stop adding characters if it won't fit
            }

            // Draw the character on the image
            imagettftext($image, $fontSize, $angle, $x, 30, $text_color, $fontPath, $char);

            // Move the x position for the next character, adding a little spacing
            $x += $charWidth + 5; // Add a little spacing between characters
        }
        // Define the path to save the CAPTCHA image
        $imagePath = FCPATH . 'uploads/captcha/captcha.png'; // Save directly to public/uploads/captcha

        // Ensure the directory exists
        // if (!is_dir(FCPATH . 'uploads/captcha')) {
        //     mkdir(FCPATH . 'uploads/captcha', 0755, true); // Create the directory if it doesn't exist
        // }

        // Output the image to the specified path
        if (!imagepng($image, $imagePath)) {
            die('Failed to save image'); // Error handling
        }
        
        imagedestroy($image);

        // Clean output buffer
        ob_end_flush();

        // Redirect to the image URL
        // return redirect()->to(base_url('uploads/captcha/captcha.png'));
        readfile($imagePath);
    }

}
