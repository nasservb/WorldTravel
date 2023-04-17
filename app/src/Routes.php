<?php 
namespace nasservb\AgencyAssistant;
use nasservb\AgencyAssistant\Controllers\AuthController;
use nasservb\AgencyAssistant\Controllers\DefaultController;
use nasservb\AgencyAssistant\Controllers\BookingController;
use nasservb\AgencyAssistant\Controllers\TransferController;

class Routes
{
    public static function route()
    {
        $request = $_SERVER['REQUEST_URI'];

        switch ($request) {
        case '':
        case '/':
        case (substr($request, 0, 7)=='/front/'):    
            return (new DefaultController)->index();
                break;

        case '/auth/login':                
            return (new AuthController)->login();
                break;

        case '/auth/logout':
            return (new AuthController)->logout();
                break;
                
        /*******
        * booking
        **********/
        case (substr($request, 0, 9)=='/book/add'):
            return (new BookingController)->book();
                break;

        case '/book/list':
            return (new BookingController)->getBooks();
                break;

        case (substr($request, 0, 10)=='/book/view'):
            return (new BookingController)->getBookDetails();
                break;

        /*******
        * transfer
        **********/ 
        case (substr($request, 0, 16)=='/transfer/search'):
            return (new TransferController)->search();
                break;
        case (substr($request, 0, 14)=='/transfer/view'):
            return (new TransferController)->getTransferDetails();
                break;

        /*******
        * others
        **********/ 
        case '/place/list':
            return (new TransferController)->getPlaces();
                break;

        case '/vehicle/list':
            return (new TransferController)->getVehicleClasses();
                break;
                
        default:
            http_response_code(404);
            return (new DefaultController)->error(404);
                break;
        }
    }
}

   