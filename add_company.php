<?php 


function aistore_add_company(){
    
  if (isset($_POST['submit']) and $_POST['action'] == 'company_system')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
               global $wpdb;
               $user_id = get_current_user_id();
             $company_name = sanitize_text_field($_REQUEST['company_name']);
            $pan_number = sanitize_text_field($_REQUEST['pan_number']);
            $gst_number = sanitize_text_field($_REQUEST['gst_number']);
            $address = sanitize_text_field($_REQUEST['address']);
            
             $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}company ( company_name, pan_number,gst_number,address,user_id ) VALUES (%s ,%s,%s,%s,%s)", array(
            $company_name,
            $pan_number,
            $gst_number,
            $address,
            $user_id
           
        )));
  
    
            $data= getaccount();
            
          $url= $_SERVER['SERVER_NAME'];
          
          

    $file_path = 'https://'.$url.'/wp-content/uploads/documents/csvaccountdata/Chart_of_Accounts.csv';
              
              
           
              
        if (($open = fopen($file_path, "r")) !== FALSE) 
  {
  
    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
    {        
      $array[] = $data; 
    }
  
    fclose($open);
  }


            foreach ($array as $c)
            {
                // echo  $c[4];
// print_r($c);

// }

  global $wpdb;
     $user_id = get_current_user_id();
  $q1 = $wpdb->prepare("INSERT INTO {$wpdb->prefix}accounts (account,type,  user_id) VALUES (%s,%s, %s)", array(
            $c[4],
            'debit',
            $user_id
        ));

        $wpdb->query($q1);
        
         $q2 = $wpdb->prepare("INSERT INTO {$wpdb->prefix}subaccounts  (account,subaccount,type,  user_id) VALUES (%s,%s, %s,%s)", array(
            $c[4],
              $c[1],
            'debit',
            $user_id
        ));

        $wpdb->query($q2);
        }
           
}
else{
?>
   
<form method="POST" action="" name="company_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

  <label for="title"><?php _e('Company Name', 'aistore'); ?></label><br>
  <input class="input" type="text" id="company_name" name="company_name"><br>

  <label for="title"><?php _e('PAN Number', 'aistore'); ?></label><br>
  <input class="input" type="text" id="pan_number" name="pan_number"><br>

  <label for="title"><?php _e('GST Number', 'aistore'); ?></label><br>
  <input class="input" type="text" id="gst_number" name="gst_number"><br>
  
  <label for="country"><?php _e('Address', 'aistore'); ?></label><br>
  <textarea id="address" name="address" rows="3" cols="40">
Address
</textarea><br><br>
  
  
      
 <input type="submit" class="btn" name="submit" value="<?php _e('Submit', 'aistore') ?>"/>
<input type="hidden" name="action" value="company_system" />

</form>  

   <?php
   
}   
}


    
function getaccount()
{
 $data="array( [0] => Account ID [1] => Account Name [2] => Account Code [3] => Description [4] => Account Type [5] => Mileage Rate [6] => Mileage Unit [7] => IsMileage [8] => Account # [9] => Currency [10] => Parent Account ) [1] => Array ( [0] => 3009506000000010001 [1] => Other Charges [2] => [3] => Miscellaneous charges like adjustments made to the invoice can be recorded in this account. [4] => Income [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [2] => Array ( [0] => 3009506000000032023 [1] => Lodging [2] => [3] => Any expense related to putting up at motels etc while on business travel can be entered here. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [3] => Array ( [0] => 3009506000000000358 [1] => Undeposited Funds [2] => [3] => Record funds received by your company yet to be deposited in a bank as undeposited funds and group them as a current asset in your balance sheet. [4] => Cash [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [4] => Array ( [0] => 3009506000000000361 [1] => Petty Cash [2] => [3] => It is a small amount of cash that is used to pay your minor or casual expenses rather than writing a check. [4] => Cash [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [5] => Array ( [0] => 3009506000000000364 [1] => Accounts Receivable [2] => [3] => The money that customers owe you becomes the accounts receivable. A good example of this is a payment expected from an invoice sent to your customer. [4] => Accounts Receivable [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [6] => Array ( [0] => 3009506000000000367 [1] => Furniture and Equipment [2] => [3] => Purchases of furniture and equipment for your office that can be used for a long period of time usually exceeding one year can be tracked with this account. [4] => Fixed Asset [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [7] => Array ( [0] => 3009506000000000370 [1] => Advance Tax [2] => [3] => Any tax which is paid in advance is recorded into the advance tax account. This advance tax payment could be a quarterly, half yearly or yearly payment. [4] => Other Current Asset [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [8] => Array ( [0] => 3009506000000000373 [1] => Accounts Payable [2] => [3] => This is an account of all the money which you owe to others like a pending bill payment to a vendor,etc. [4] => Accounts Payable [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [9] => Array ( [0] => 3009506000000000376 [1] => Tax Payable [2] => [3] => The amount of money which you owe to your tax authority is recorded under the tax payable account. This amount is a sum of your outstanding in taxes and the tax charged on sales. [4] => Other Current Liability [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [10] => Array ( [0] => 3009506000000000379 [1] => Retained Earnings [2] => [3] => The earnings of your company which are not distributed among the share holders is accounted as retained earnings. [4] => Equity [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [11] => Array ( [0] => 3009506000000000382 [1] => Owner's Equity [2] => [3] => The owners rights to the assets of a company can be quantified in the owner''s equity account. [4] => Equity [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [12] => Array ( [0] => 3009506000000000385 [1] => Opening Balance Offset [2] => [3] => This is an account where you can record the balance from your previous years earning or the amount set aside for some activities. It is like a buffer account for your funds. [4] => Equity [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [13] => Array ( [0] => 3009506000000000388 [1] => Sales [2] => [3] => The income from the sales in your business is recorded under the sales account. [4] => Income [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [14] => Array ( [0] => 3009506000000000391 [1] => General Income [2] => [3] => A general category of account where you can record any income which cannot be recorded into any other category. [4] => Income [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [15] => Array ( [0] => 3009506000000005001 [1] => Unearned Revenue [2] => [3] => A liability account that reports amounts received in advance of providing goods or services. When the goods or services are provided, this account balance is decreased and a revenue account is increased. [4] => Other Current Liability [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [16] => Array ( [0] => 3009506000000000394 [1] => Interest Income [2] => [3] => A percentage of your balances and deposits are given as interest to you by your banks and financial institutions. This interest is recorded into the interest income account. [4] => Income [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [17] => Array ( [0] => 3009506000000000397 [1] => Late Fee Income [2] => [3] => Any late fee income is recorded into the late fee income account. The late fee is levied when the payment for an invoice is not received by the due date. [4] => Income [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [18] => Array ( [0] => 3009506000000000400 [1] => Office Supplies [2] => [3] => All expenses on purchasing office supplies like stationery are recorded into the office supplies account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [19] => Array ( [0] => 3009506000000000403 [1] => Advertising And Marketing [2] => [3] => Your expenses on promotional, marketing and advertising activities like banners, web-adds, trade shows, etc. are recorded in advertising and marketing account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [20] => Array ( [0] => 3009506000000000406 [1] => Discount [2] => [3] => Any reduction on your selling price as a discount can be recorded into the discount account. [4] => Income [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [21] => Array ( [0] => 3009506000000000409 [1] => Bank Fees and Charges [2] => [3] => Any bank fees levied is recorded into the bank fees and charges account. A bank account maintenance fee, transaction charges, a late payment fee are some examples. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [22] => Array ( [0] => 3009506000000000412 [1] => Credit Card Charges [2] => [3] => Service fees for transactions , balance transfer fees, annual credit fees and other charges levied on a credit card are recorded into the credit card account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [23] => Array ( [0] => 3009506000000000415 [1] => Exchange Gain or Loss [2] => [3] => Changing the conversion rate can result in a gain or a loss. You can record this into the exchange gain or loss account. [4] => Other Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [24] => Array ( [0] => 3009506000000000418 [1] => Travel Expense [2] => [3] => Expenses on business travels like hotel bookings, flight charges, etc. are recorded as travel expenses. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [25] => Array ( [0] => 3009506000000000421 [1] => Telephone Expense [2] => [3] => The expenses on your telephone, mobile and fax usage are accounted as telephone expenses. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [26] => Array ( [0] => 3009506000000000424 [1] => Automobile Expense [2] => [3] => Transportation related expenses like fuel charges and maintenance charges for automobiles, are included to the automobile expense account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [27] => Array ( [0] => 3009506000000000427 [1] => IT and Internet Expenses [2] => [3] => Money spent on your IT infrastructure and usage like internet connection, purchasing computer equipment etc is recorded as an IT and Computer Expense. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [28] => Array ( [0] => 3009506000000000430 [1] => Rent Expense [2] => [3] => The rent paid for your office or any space related to your business can be recorded as a rental expense. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [29] => Array ( [0] => 3009506000000000433 [1] => Janitorial Expense [2] => [3] => All your janitorial and cleaning expenses are recorded into the janitorial expenses account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [30] => Array ( [0] => 3009506000000014001 [1] => Shipping Charge [2] => [3] => Shipping charges made to the invoice will be recorded in this account. [4] => Income [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [31] => Array ( [0] => 3009506000000000436 [1] => Postage [2] => [3] => Your expenses on ground mails, shipping and air mails can be recorded under the postage account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [32] => Array ( [0] => 3009506000000000439 [1] => Bad Debt [2] => [3] => Any amount which is lost and is unrecoverable is recorded into the bad debt account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [33] => Array ( [0] => 3009506000000003001 [1] => Opening Balance Adjustments [2] => [3] => This account will hold the difference in the debits and credits entered during the opening balance. [4] => Other Current Liability [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [34] => Array ( [0] => 3009506000000035001 [1] => Employee Advance [2] => [3] => Money paid out to an employee in advance can be tracked here till it's repaid or shown to be spent for company purposes. [4] => Other Current Asset [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [35] => Array ( [0] => 3009506000000000442 [1] => Printing and Stationery [2] => [3] => Expenses incurred by the organization towards printing and stationery. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [36] => Array ( [0] => 3009506000000035003 [1] => Employee Reimbursements [2] => [3] => This account can be used to track the reimbursements that are due to be paid out to employees. [4] => Other Current Liability [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [37] => Array ( [0] => 3009506000000000445 [1] => Salaries and Employee Wages [2] => [3] => Salaries for your employees and the wages paid to workers are recorded under the salaries and wages account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [38] => Array ( [0] => 3009506000000035005 [1] => Uncategorized [2] => [3] => This account can be used to temporarily track expenses that are yet to be identified and classified into a particular category [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [39] => Array ( [0] => 3009506000000000448 [1] => Meals and Entertainment [2] => [3] => Expenses on food and entertainment are recorded into this account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [40] => Array ( [0] => 3009506000000000451 [1] => Depreciation Expense [2] => [3] => Any depreciation in value of your assets can be captured as a depreciation expense. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [41] => Array ( [0] => 3009506000000000454 [1] => Consultant Expense [2] => [3] => Charges for availing the services of a consultant is recorded as a consultant expenses. The fees paid to a soft skills consultant to impart personality development training for your employees is a good example. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [42] => Array ( [0] => 3009506000000000457 [1] => Repairs and Maintenance [2] => [3] => The costs involved in maintenance and repair of assets is recorded under this account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [43] => Array ( [0] => 3009506000000045001 [1] => Tag Adjustments [2] => [3] => This adjustment account tracks the transfers between different reporting tags. [4] => Other Liability [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [44] => Array ( [0] => 3009506000000000460 [1] => Other Expenses [2] => [3] => Any minor expense on activities unrelated to primary business operations is recorded under the other expense account. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [45] => Array ( [0] => 3009506000000034001 [1] => Inventory Asset [2] => [3] => An account which tracks the value of goods in your inventory. [4] => Stock [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [46] => Array ( [0] => 3009506000000034003 [1] => Cost of Goods Sold [2] => [3] => An expense account which tracks the value of the goods sold. [4] => Cost Of Goods Sold [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [47] => Array ( [0] => 3009506000000012001 [1] => Drawings [2] => [3] => The money withdrawn from a business by its owner can be tracked with this account. [4] => Equity [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [48] => Array ( [0] => 3009506000000072001 [1] => Purchase Discounts [2] => [3] => Tracks any reduction that your vendor offers on your purchases. Some vendors also provide them to encourage quick payment settlement. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [49] => Array ( [0] => 3009506000000074012 [1] => Prepaid Expenses [2] => [3] => An asset account that reports amounts paid in advance while purchasing goods or services from a vendor. [4] => Other Current Asset [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [50] => Array ( [0] => 3009506000000074016 [1] => TDS Receivable [2] => [3] => [4] => Other Current Asset [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [51] => Array ( [0] => 3009506000000074020 [1] => TDS Payable [2] => [3] => [4] => Other Current Liability [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [52] => Array ( [0] => 3009506000000074052 [1] => Mortgages [2] => [3] => An expense account that tracks the amounts you pay for the mortgage loan. [4] => Long Term Liability [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [53] => Array ( [0] => 3009506000000074056 [1] => Construction Loans [2] => [3] => An expense account that tracks the amount you repay for construction loans. [4] => Long Term Liability [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [54] => Array ( [0] => 3009506000000074060 [1] => Investments [2] => [3] => An equity account used to track the amount that you invest. [4] => Equity [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [55] => Array ( [0] => 3009506000000074062 [1] => Distributions [2] => [3] => An equity account that tracks the payment of stock, cash or physical products to its shareholders. [4] => Equity [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [56] => Array ( [0] => 3009506000000074064 [1] => Labor [2] => [3] => An expense account that tracks the amount that you pay as labor. [4] => Cost Of Goods Sold [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [57] => Array ( [0] => 3009506000000074068 [1] => Materials [2] => [3] => An expense account that tracks the amount you use in purchasing materials. [4] => Cost Of Goods Sold [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [58] => Array ( [0] => 3009506000000074072 [1] => Subcontractor [2] => [3] => An expense account to track the amount that you pay subcontractors who provide service to you. [4] => Cost Of Goods Sold [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [59] => Array ( [0] => 3009506000000074076 [1] => Job Costing [2] => [3] => An expense account to track the costs that you incur in performing a job or a task. [4] => Cost Of Goods Sold [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [60] => Array ( [0] => 3009506000000074080 [1] => Capital Stock [2] => [3] => An equity account that tracks the capital introduced when a business is operated through a company or corporation. [4] => Equity [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [61] => Array ( [0] => 3009506000000074082 [1] => Dividends Paid [2] => [3] => An equity account to track the dividends paid when a corporation declares dividend on its common stock. [4] => Equity [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [62] => Array ( [0] => 3009506000000074084 [1] => Raw Materials And Consumables [2] => [3] => An expense account to track the amount spent on purchasing raw materials and consumables. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [63] => Array ( [0] => 3009506000000074088 [1] => Merchandise [2] => [3] => An expense account to track the amount spent on purchasing merchandise. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [64] => Array ( [0] => 3009506000000074092 [1] => Transportation Expense [2] => [3] => An expense account to track the amount spent on transporting goods or providing services. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [65] => Array ( [0] => 3009506000000074096 [1] => Depreciation And Amortisation [2] => [3] => An expense account that is used to track the depreciation of tangible assets and intangible assets, which is amortization. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [66] => Array ( [0] => 3009506000000074100 [1] => Contract Assets [2] => [3] => An asset account to track the amount that you receive from your customers while you're yet to complete rendering the services. [4] => Expense [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [67] => Array ( [0] => 3009506000000074218 [1] => Paytm [2] => [3] => [4] => Bank [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [68] => Array ( [0] => 3009506000000080627 [1] => Credit Card Bills [2] => [3] => [4] => Fixed Asset [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [69] => Array ( [0] => 3009506000000082001 [1] => State Bank of india [2] => [3] => [4] => Bank [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) [70] => Array ( [0] => 3009506000000083663 [1] => Donation to ISKON [2] => [3] => [4] => Fixed Asset [5] => 0.000 [6] => [7] => false [8] => [9] => INR [10] => ) ) ";
 
 return ($data);

}
