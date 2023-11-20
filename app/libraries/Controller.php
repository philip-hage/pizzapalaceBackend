<?php
// De parent controllerclass laad de model en de view

class Controller
{
    public function model($model)
    {
        // Pad naar de modelclass bestand opgeven
        require_once APPROOT . '/models/' . $model . '.php';

        // Nieuw object van de opgegeven model
        return new $model();
    }


    public function view($view, $data = [])
    {
        if (file_exists(APPROOT . '/views/includes/Header.php')) {
            require_once APPROOT . '/views/includes/Header.php';
        }
        if (file_exists(APPROOT . '/views/' . $view . '.php')) {
            require_once(APPROOT . '/views/' . $view . '.php');
        } else {
            die('View bestaat niet');
        }
        if (file_exists(APPROOT . '/views/includes/footer.php')) {
            require_once APPROOT . '/views/includes/footer.php';
        }
    }

    public function pagination($pageNumber, $recordsPerPage, $totalRecords)
    {
        $totalPages = ceil($totalRecords / $recordsPerPage);
        $offset = ($pageNumber - 1) * $recordsPerPage;
        $nextPage = ($pageNumber < $totalPages) ? $pageNumber + 1 : null;
        $previousPage = ($pageNumber > 1) ? $pageNumber - 1 : null;

        // Determine first, second, and third pages
        $firstPage = max(1, $pageNumber - 1);
        $secondPage = $pageNumber;
        $thirdPage = min($totalPages, $pageNumber + 1);

        return [
            'pageNumber' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'offset' => $offset,
            'nextPage' => $nextPage,
            'previousPage' => $previousPage,
            'totalPages' => $totalPages,
            'firstPage' => $firstPage,
            'secondPage' => $secondPage,
            'thirdPage' => $thirdPage
        ];
    }


    public function imageUploader($screenId)
    {
        // Define the allowed file types
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'bmp'];

        // Check if the file input is set and not empty
        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $file = $_FILES['file'];

            // Get the file extension
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            // Check if the file extension is allowed
            if (in_array($fileExtension, $allowedExtensions)) {
                // Create the directory if it doesn't exist
                $uploadDir = ROOT . '/public/media/' . date('Ymd');
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Generate the filename using the provided screenId
                $filename = $screenId . '.jpg';
                $filePath = $uploadDir . '/' . $filename;

                // Check if the file is successfully moved and saved
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    // Return a success message or the file path
                    return array(
                        'status' => 200,
                        'message' => 'Image uploaded successfully'
                    );
                } else {
                    return array(
                        'status' => 500,
                        'message' => 'Error uploading image. Please try again.'
                    );
                }
            } else {
                return 'Invalid file type. Allowed types are: ' . implode(', ', $allowedExtensions);
            }
        } else {
            return 'No file selected for upload.';
        }
    }
}
