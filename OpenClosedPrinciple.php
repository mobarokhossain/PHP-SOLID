<?php

// Open Closed Principle Violation
class PaymentRequest {

    public function payWithCard()
    {
        echo 'Payment is processing via card...' . PHP_EOL;
    }

    public function payWithBkash()
    {
        echo 'Payment is processing via bKash...' . PHP_EOL;
    }

}

class Payment {

    public function pay($method)
    {
        $paymentRequest = new PaymentRequest();

        switch ($method) {
            case 'card':
                $paymentRequest->payWithCard();
                break;
            case 'bkash':
                $paymentRequest->payWithBkash();
                break;
            default:
                exit('Invalid payment method!');
                break;
        }
        
    }

}

/* $payment = new Payment();
$payment->pay('bkash'); */


// Refactored
interface PayableInterface {
    public function pay();
}

class CreditCardPayment implements PayableInterface {

    public function pay()
    {
        echo 'Payment is processing via credit card...' . PHP_EOL;
    }

}

class BkashPayment implements PayableInterface {    

    public function pay()
    {
        echo 'Payment is processing via bKash...' . PHP_EOL;
    }

}

class PaymentFactory {

    public function initialize($method)
    {
        switch ($method) {
            case 'card':
                return new CreditCardPayment();
                break;
            case 'bkash':
                return new BkashPayment();
                break;
            default:
                exit('Invalid payment method!');
                break;
        }
    }

}

$paymentFactory = new PaymentFactory();
$payment = $paymentFactory->initialize('bkash');
$payment->pay();
