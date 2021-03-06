<?php
class Restaurant {

    // database connection and table name
    private $conn;
    private $dishes_table_name = "Dishes";
    private $restaurant_table_name = "Restaurants";
    private $review_table_name = "Reviews";
    private $user_table_name = "Users";

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getRestaurantImage($res_id) {
        // Defined query
        $query = "SELECT Restaurants.image FROM Restaurants WHERE restaurant_id=" . $res_id . ";";

        // Perform queries
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            var_dump($result);
        }

        // Processing and return results in JSON
        $restaurant_image;
        while($row =  mysqli_fetch_row($result)) {
            $restaurant_image = $row[0];
        }

        return $restaurant_image;
    }

    public function getRestaurantMenu($res_id) {
        // Defined query
        $query = "SELECT Dishes.dish_name, Dishes.desc, Dishes.price, Dishes.img_link FROM Dishes WHERE restaurant_id=" . $res_id . ";";

        // Perform queries
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            var_dump($result);
        }

        // Processing and return results in JSON
        $restaurant_menu = array();
        while($row = mysqli_fetch_assoc($result)) {
            $restaurant_menu[] = $row;
        }

        return $restaurant_menu;
    }

    public function getRestaurantDetail($res_id) {

        $restaurant_details = new stdClass;
        $restaurant_details->image = $this->getRestaurantImage($res_id);
        $restaurant_details->menu = $this->getRestaurantMenu($res_id);

        echo json_encode($restaurant_details);
    }

    public function getReview($res_id) {
        // $query = "SELECT * FROM ".$this->review_table_name." WHERE restaurant_id=".$res_id;
        //$query = "SELECT review, rating, user_name FROM Reviews inner join Users on Reviews.user_id = Users.user_id WHERE Reviews.restaurant_id = 1"
        $query = "SELECT review, rating, user_name, user_avt, restaurant_id FROM Reviews INNER JOIN Users ON Reviews.user_id = Users.user_id WHERE restaurant_id=".$res_id;
        $result = mysqli_query($this->conn, $query);

        if (!$result){
          var_dump($result);
        }

        $restaurant_review = array();
        while($row = mysqli_fetch_assoc($result)){
          $restaurant_review[] = $row;
        }

        echo json_encode($restaurant_review);

        mysqli_close($this->conn);
    }
}
