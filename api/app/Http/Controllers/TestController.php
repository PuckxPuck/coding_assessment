<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Recipient;
use Illuminate\Support\Facades\DB;



class TestController extends Controller
{
    public function sendMessages(){
        
        // Number of Messages to process in each batch
        $batchSize = 10;

        // Retrieve the count of scheduled messages
        $queuedMessagesCount = Message::where('status', 'scheduled')
        ->where('scheduled_date', '<=', now())
        ->count();


        // Check how many batches are needed
        $totalBatches = ceil($queuedMessagesCount / $batchSize);

        for ($batch = 1; $batch <= $totalBatches; $batch++) {

            // Retrieve the batch to send the message, will be sent based on
            // scheduled date asceding order this will ensure that time-sensitive messages are sent fast
            $messages = Message::where('status', 'scheduled')
            ->where('scheduled_date', '<=', now())
            ->orderby('scheduled_date', 'asc')
            ->limit($batchSize) 
            ->get();
    
            // Begin a transaction to process the messages
            DB::beginTransaction();
    
            try {

                // Mark the selected messages as 'sending'
               Message::whereIn('id', $messages->pluck('id'))->update(['status' => 'sending']);
    
               // Commit the transactions or abort the transaction if something went wrong
               DB::commit();
    
               // Process the messages in the batch
               foreach($messages as $message){

                    // Retrieve and process the recipients for each message
                    $recipients = Recipient::where('message_id', $message->id)->get();
        
                    // Send Messages to the recipients
                    foreach($recipients as $recipient){
                         // Impelement Delivery Logic
                    }
    
                    // Update the delivery status for each recipient
                    $recipientIds = $recipients->pluck('id');
    
                    Recipient::whereIn('id', $recipientIds)->update(['status' => 'delivered', 'delivered_date' => now()]);
                    
                    // Mark the message as 'delivered' and update the delivery date 
                    $message->status = 'delivered';
                    $message->delivered_date = now();
                    $message->save();
                
                }
            } catch (\Exception $e) {

                // Handle any exception and rollback the transaction if neccessary
                DB::rollBack();
                throw $e;
            }
        }

        return response()->json(['success' => true, 'message' => 'Messages sent successfully']);
    }
}
