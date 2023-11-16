<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
    // Replace these with your actual database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "regform";

    // Create a database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve and sanitize form data
    $first_name = mysqli_real_escape_string($conn, $_POST["FirstName"]);
    $last_name = mysqli_real_escape_string($conn, $_POST["LastName"]);
    $email = mysqli_real_escape_string($conn, $_POST["EmailID"]);
 
    $gender = mysqli_real_escape_string($conn, $_POST["Gender"]);
    $mobile_number = mysqli_real_escape_string($conn, $_POST["MobileNumber"]);
    $address = mysqli_real_escape_string($conn, $_POST["Address"]);
   
    $state = mysqli_real_escape_string($conn, $_POST["State"]);
    $country = mysqli_real_escape_string($conn, $_POST["Country"]);
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) 
    {
        $uploadsDirectory = 'uploads/';
        $imageFileName = basename($_FILES['image']['name']);
        $imagePath = $uploadsDirectory . $imageFileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath))
         {
            echo "File uploaded successfully.";
        } else 
        {
            echo "Error uploading file.";
        }
    }

    $first_name = strtoupper($first_name);
    $last_name = strtoupper($last_name);

   
    $sql = "INSERT INTO reg_details (first_name, last_name, email, gender, mobile_number, address, state, country, imagePath )
            VALUES ('$first_name', '$last_name', '$email',  '$gender', '$mobile_number', '$address', '$state', '$country','$imagePath')";

    if (mysqli_query($conn, $sql)) {
        // Data inserted successfully
        echo "Data submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>