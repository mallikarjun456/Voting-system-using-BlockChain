<?php
class BallotBoxDB extends SQLite3
{
    function __construct()
    {
        $this->open('../db/ballot_box.db');
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM users AS U WHERE U.username = '$username' AND U.password = '$password'";
        $res = $this->querySingle($sql, true);

        return $res;
    }

    public function get_users() {
        $sql = "SELECT * FROM users";
        $res = $this->query($sql);

        return $res;
    }
	
	public function get_users_from_mob_no($mob_no) {
        $sql = "SELECT * FROM users where mobile_number='$mob_no'";
        $res = $this->query($sql);

        return $res;
    }

    public function get_user($id) {
        $sql = "SELECT * FROM users WHERE id='$id'";
        $res = $this->querySingle($sql, true);

        return $res;
    }
	
	public function get_user_data_from_userid($id) {
        $sql = "SELECT * FROM users WHERE username='$id'";
        $res = $this->querySingle($sql, true);

        return $res;
    }

    public function create_user($first_name, $middle_name, $last_name, $username, $password) {
        $sql = "INSERT INTO users (first_name, middle_name, last_name, username, password, is_admin) VALUES ('$first_name', '$middle_name', '$last_name', '$username', '$password', false)";
        
        try {
            $res = $this->exec($sql);

            if($res) {
                //restore the previous error handler
                restore_error_handler();

                return $this->lastInsertRowID();
            }
            else {
                throw new Exception('Could not create user');
            }
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
	
	public function create_user_outer($first_name, $middle_name, $last_name, $username, $password,$mobile_number,$aadhar_no,$voter_id_no,$dob) {
        $sql = "INSERT INTO users (first_name, middle_name, last_name, username, password, is_admin,mobile_number,aadhar_no,voter_id,dob) VALUES ('$first_name', '$middle_name', '$last_name', '$username', '$password', false,'$mobile_number','$aadhar_no','$voter_id_no','$dob')";
        
        try {
            $res = $this->exec($sql);

            if($res) {
                //restore the previous error handler
                restore_error_handler();

                return $this->lastInsertRowID();
            }
            else {
                throw new Exception('Could not create user');
            }
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function updateUser($id, $first_name, $middle_name, $last_name, $password,$mobile_number,$aadhar_no,$voter_id_no,$dob) {
        $sql = "UPDATE users SET first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name', password = '$password', mobile_number='$mobile_number',aadhar_no='$aadhar_no',voter_id='$voter_id_no',dob='$dob' WHERE id = '$id'";
        $res = $this->exec($sql);

        return $res;
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users where id = '$id'";
        $res = $this->exec($sql);

        return $res;
    }

    public function get_polls() {
        $sql = "SELECT * FROM polls";
        $res = $this->query($sql);

        return $res;
    }

    public function get_poll($id) {
        $sql = "SELECT * FROM polls WHERE id = '$id'";
        $res = $this->querySingle($sql, true);

        return $res;
    }

    public function create_poll($poll_name, $poll_desc, $option_1, $option_2, $option_3, $option_4) {
        $sql = "INSERT INTO polls (poll_name, poll_desc, option_1, option_2, option_3, option_4) VALUES ('$poll_name', '$poll_desc', '$option_1', '$option_2', '$option_3', '$option_4')";
        $res = $this->exec($sql);

        if($res) {
            return $this->lastInsertRowID();
        }
        return $res;
    }

    public function update_poll($id, $poll_name, $poll_desc, $opt_1, $opt_2, $opt_3, $opt_4) {
        $sql = "UPDATE polls SET poll_name = '$poll_name', poll_desc='$poll_desc', option_1 = '$opt_1', option_2 = '$opt_2', option_3 = '$opt_3', option_4 = '$opt_4' WHERE id='$id'";
        $res = $this->exec($sql);

        return $res;
    }

    public function delete_poll($id) {
        $sql = "DELETE FROM polls WHERE id = '$id'";
        $res = $this->exec($sql);

        return $res;
    }
}
?>