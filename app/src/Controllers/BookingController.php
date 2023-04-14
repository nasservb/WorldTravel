<?php
namespace nasservb\AgencyAssistant\Controllers;

use nasservb\AgencyAssistant\Models\User;
use nasservb\AgencyAssistant\Models\Booking;
use nasservb\AgencyAssistant\Models\Transfer;
use nasservb\AgencyAssistant\Events\SendMail;

class BookingController extends BaseController
{

    private $user; 

    public function __construct()
    {
        $this->user = new User('');        
    }

    public function book()
    {
        if (!$this->user->checkLogin()) {
            return $this->render('Authentication required!', 403);
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return  $this->render('Bad Request', 401);
        }

        $currentUser = $this->user->getCurrentUser();  

        $transfer = Transfer::find($this->post('transfer_id'));
        
        if(!is_array($transfer) || empty($transfer['id'])) {
            return $this->render('the transfer is not valid!', 422);
        }

        $user = $this->user->findById($this->post('user_id'));
        if(!$user->getId()) {
            $user =$currentUser;
        }

        $seatsBooked = $this->post('seats_no');
        if(intval($seatsBooked) <= 0 && !is_array($seatsBooked)) {
            return $this->render('the seats_no is not valid!', 422);
        }

        $booked = false ; 
        
        if (is_array($seatsBooked)) {
            foreach($seatsBooked as $seat){
                $book = new Booking($user['id'], $transfer, $seat, $currentUser['id']);
                $book->save();
            }
            $booked = true  ; 
        }
        else 
        {
            $book = new Booking($user['id'], $transfer, $seatsBooked, $currentUser['id']);
            if($book->save()->getId() > 0 ) {
                $booked = true ;                 
            }
        }
        
        if ($booked) {
            (new SendMail())->Fire(['subject'=>'New Ticket', 'message'=>'Your Ticket has been created' , 'to'=>$currentUser['email_address']]); 

            return $this->render(1, 200);
        }
        
        return $this->render('error in booking', 500);
    }

    public function getBooks()
    {
        if (!$this->user->checkLogin()) {
            return $this->render('Authentication required!', 403);
        }

        $currentUser = $this->user->getCurrentUser(); 
         
        $books =Booking::getBooksByUserId($currentUser['id']);
        return $this->render($books, 200);
    }

    public function getBookDetails()
    {
        if (!$this->user->checkLogin()) {
            return $this->render('Authentication required!', 403);
        }
        
        $book = Booking::getById($this->get('id'));
        
        if(!is_array($book)) {
            return $this->render('the id is not valid!', 422);
        }

        return $this->render($book, 200);
    }
}