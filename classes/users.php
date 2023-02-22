<?php
require_once "Db-connection.php";

class User {
    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $password;
    private $phone_number;
    private $company_name;
    private $company_site;
    private $company_description;
    private $company_image;
    private $is_admin;
    public $err;
    public $work_data;
    public $is_clear;

    function sanitize($data){
        foreach($data as $d){
            $d = htmlspecialchars($d);
            $d = stripslashes($d);
            $d = trim($d);
        }
       return $data;
    }

    function update_password($conn, $password){
        $error = "";
        $clear = true;
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if(!$uppercase || !$lowercase ||  !$specialChars || strlen($password) < 8) {
            $error = 'Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter, and one special character.';
            $clear = false;
        }
        if($clear == true){
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users set password = ? where id = ?");
            $stmt->bind_param("ss", $password, $this->id);
            $stmt->execute();
        }
        return $error;
    }

    function clear_data($work_data, $conn){
        $err = array(
            'first_name_err' => "",
            'last_name_err'  => "",
            'password_err'   => "",
            'email_err'      => "",
            'repeat_err'     => "",
            'phone_err'      => "",
            'site_err'       => ""
        );
        $clear = true;
        if(empty($work_data["first_name"])){
            $err["first_name_err"] = "First name is reqired!";
            $clear = false;
        };
        if(empty($work_data["last_name"])){
            $err["last_name_err"] = "Last name is reqired!";
            $clear = false;
        };
        if(empty($work_data["email"])){
            $err["email_err"] = "Email is reqired!";
            $clear = false;
        };
        if(empty($work_data["password"])){
            $err["password_err"] = "Password is reqired!";
            $clear = false;
        };
        if(isset($work_data["password"])){
            if(strcmp($work_data["password"], $this->password) === 0){
                $clear = true;
            }
        }
        if(empty($work_data["repeat"])){
            $err["repeat_err"] = "You have to repeat the password!";
            $clear = false;
        };
        $user_data = array(
            'id'            => "",
            'first_name' 	=> "",
            'last_name'  	=> "",
            'email'		 	=> "",
            'password'	 	=> "",
            'phone'	     	=> "",
            'company_name'  => "",
            'company_site'  => "",
            'description'   => "",
            'company_image' => "",
            'is_admin'		=> false
        );
        if(isset($work_data["id"])){
            $user_data["id"] = $work_data["id"];
        }
        if(isset($work_data["first_name"])){
            $user_data["first_name"] = $work_data["first_name"];
        }
        if(isset($work_data["last_name"])){
            $user_data["last_name"] = $work_data["last_name"];
        }
        if(isset($work_data["email"])){
            $user_data["email"] = $work_data["email"];
        }
        if(isset($work_data["password"])){
            $user_data["password"] = password_hash($work_data["password"], PASSWORD_DEFAULT);
        }
        if(isset($work_data["phone"])){
            $user_data["phone"] = $work_data["phone"];
        }
        if(isset($work_data["companyName"])){
            $user_data["company_name"] = $work_data["companyName"];
        }
        if(isset($work_data["companySite"])){
            $user_data["company_site"] = $work_data["companySite"];
        }
        if(isset($work_data["description"])){
            $user_data["description"] = $work_data["description"];
        }
        if(isset($work_data["repeat"])){
            $user_data["repeat"] = $work_data["repeat"];
            if($work_data["password"] != $work_data["repeat"] && !empty($work_data["password"]) && !empty($work_data["repeat"])){
                $err["password_err"] = "Passwords do not match!";
                $clear = false;
            }
        }
        if(isset($work_data["company_image"])){
            $user_data["company_image"] = $work_data["company_image"];
        }
        if(isset($work_data["password"])){
            $uppercase = preg_match('@[A-Z]@', $work_data["password"]);
            $lowercase = preg_match('@[a-z]@', $work_data["password"]);
            $specialChars = preg_match('@[^\w]@', $work_data["password"]);

            if(!$uppercase || !$lowercase ||  !$specialChars || strlen($work_data["password"]) < 8) {
                $err["password_err"] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter, and one special character.';
                $clear = false;
            }
        }
        if(filter_var($user_data["email"], FILTER_VALIDATE_EMAIL) != true && !empty($work_data["email"])){
            $err["email_err"] = "Email is not valid!";
            $clear = false;
        }else{
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users Where ? = email");
            $stmt->bind_param("s", $work_data['email']);
            $stmt->execute();
            $select = $stmt->get_result();
            $result = $select->fetch_assoc();
            if($result['count'] == 0){
                $user_data['email'] = $work_data['email'];
            }else{
                $err['email_err'] = "Email already exists!";
                $clear = false;
            }
        }
        if(!filter_var($user_data["company_site"], FILTER_VALIDATE_URL) && !empty($user_data["company_site"])){
            $err["site_err"] = "Site url is not valid!";
            $clear = false;
        }
        if(!preg_match('/^[0-9]{10}+$/', $user_data["phone"])){
            $err['phone_err'] = "Phone number is not valid!";
            $clear = false;
        }
        $this->err         = $err;
        $this->work_data   = $user_data;
        $this->is_clear    = $clear;
    }

    function __construct($input, $conn)
    {
        $this->clear_data($input, $conn);
        $data = $this->work_data;
        $data = $this->sanitize($data);
        $this->id                  = $data["id"];
        $this->email               = $data["email"];
        $this->first_name          = $data["first_name"];
        $this->last_name           = $data["last_name"];
        $this->password            = $data["password"];
        $this->phone_number        = $data["phone"];
        $this->company_name        = $data["company_name"];
        $this->company_site        = $data["company_site"];
        $this->company_description = $data["description"];
        $this->company_image = $data["company_image"];
        if(strpos($data["email"], "@nbu.bg") !== false){
            $this->is_admin = 1;
        }else{
            $this->is_admin = 0;
        }
    }

    function insert_image($conn, $image){
        if(!empty($image["company_image"])){
            $pname = $image["company_image"]["name"]; 
            $tname=$image["company_image"]["tmp_name"];
            
            $name = pathinfo($image['company_image']['name'], PATHINFO_FILENAME);
            $extension = pathinfo($image['company_image']['name'], PATHINFO_EXTENSION);
            
            $increment = 0; 
            $pname = $name . '.' . $extension;
        }else{
            echo "image empty";
        }
        
        while(is_file('uploads/images'.'/'.$pname)) {
            $increment++;
            $pname = $name . $increment . '.' . $extension;
        }



        $target_file = 'uploads/images'.'/'.$pname;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "jiff") {
            $this->err["company_image_err"] = "Wrong file format!";
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
    
        } else {
            if (move_uploaded_file($tname, $target_file) && empty($this->err["company_image_err"])) {
            $company_image = basename( $pname);
            $stmt = $conn->prepare("UPDATE users SET company_image = ? WHERE email = ?");
            $stmt->bind_param("ss", $company_image, $this->email);
            $stmt->execute();
            header("Location: login.php");
            } else {
                $this->err["company_image_err"] = "Wrong file format!";
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    function insert($conn, $image){
    $stmt = $conn->prepare(
            "INSERT INTO users(
                            email,
                            first_name,
                            last_name,
                            password,
                            phone_number,
                            company_name,
                            company_site,
                            company_description,
                            company_image,
                            is_admin)
                            values(?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssss", 
                            $this->email, 
                            $this->first_name, 
                            $this->last_name, 
                            $this->password, 
                            $this->phone_number, 
                            $this->company_name, 
                            $this->company_site, 
                            $this->company_description, 
                            $this->company_image, 
                            $this->is_admin);
            if($stmt->execute()){
                if(!empty($image)){
                    $this->insert_image($conn, $image);
                }else{
                    header("Location: login.php");
                }
            }
    }
}

?>