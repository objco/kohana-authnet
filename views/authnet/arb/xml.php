<?php echo '<?xml version="1.0" encoding="utf-8"?>'."\n"; ?>
<<?php echo $type; ?> xmlns="<?php echo Kohana::config('authnet.arb.xml_schema'); ?>">
	<merchantAuthentication>
		<name><?php echo $values['login']; ?></name>
		<transactionKey><?php echo $values['tran_key']; ?></transactionKey>
	</merchantAuthentication>
<?php if ( ! empty($values['ref_id'])): ?>
	<refId><?php echo $values['ref_id']; ?></refId>
<?php endif ?>
<?php if ( ! empty($values['subscription_id'])): ?>
	<subscriptionId><?php echo $values['subscription_id']; ?></subscriptionId>
<?php endif ?>
<?php if ($type !== AuthNet_ARB::CANCEL): ?>
	<subscription>
<?php if ( ! empty($values['subscription_name'])): ?>
		<name><?php echo $values['subscription_name']; ?></name>
<?php endif ?>
<?php if ( ! empty($values['payment_interval'])
			OR ! empty($values['payment_interval_unit'])
			OR ! empty($values['start_date'])
			OR ! empty($values['total_occurrences'])
			OR ! empty($values['trial_occurrences'])
			): ?>
		<paymentSchedule>
<?php if ( ! empty($values['payment_interval']) OR ! empty($values['payment_interval_unit'])): ?>
			<interval>
<?php if ( ! empty($values['payment_interval'])): ?>
				<length><?php echo $values['payment_interval']; ?></length>
<?php endif ?>
<?php if ( ! empty($values['payment_interval_unit'])): ?>
				<unit><?php echo $values['payment_interval_unit']; ?></unit>
<?php endif ?>
			</interval>
<?php endif ?>
<?php if ( ! empty($values['start_date'])): ?>
			<startDate><?php echo date('Y-m-d', strtotime($values['start_date'])); ?></startDate>
<?php endif ?>
<?php if ( ! empty($values['total_occurrences'])): ?>
			<totalOccurrences><?php echo $values['total_occurrences']; ?></totalOccurrences>
<?php endif ?>
<?php if ( ! empty($values['trial_occurrences'])): ?>
			<trialOccurrences><?php echo $values['trial_occurrences']; ?></trialOccurrences>
<?php endif ?>
		</paymentSchedule>
<?php endif ?>
<?php if ( ! empty($values['amount'])): ?>
		<amount><?php echo $values['amount']; ?></amount>
<?php endif ?>
<?php if (isset($values['trial_amount']) AND $values['trial_amount'] != ''): ?>
		<trialAmount><?php echo $values['trial_amount']; ?></trialAmount>
<?php endif ?>
<?php if ( ! empty($values['card_num']) OR ! empty($values['account_type'])): ?>
		<payment>
<?php if ( ! empty($values['card_num'])): ?>
			<creditCard>
<?php if ( ! empty($values['card_num'])): ?>
				<cardNumber><?php echo $values['card_num']; ?></cardNumber>
<?php endif ?>
<?php if ( ! empty($values['exp_date'])): ?>
				<expirationDate><?php echo date('Y-m', strtotime($values['exp_date'])); ?></expirationDate>
<?php endif ?>
<?php if ( ! empty($values['card_code'])): ?>
				<cardCode><?php echo $values['card_code']; ?></cardCode>
<?php endif ?>
			</creditCard>
<?php elseif( ! empty($values['account_type'])): ?>
			<bankAccount>
<?php if ( ! empty($values['account_type'])): ?>
				<accountType><?php echo Arr::get($values, 'account_type', ''); ?></accountType>
<?php endif ?>
<?php if ( ! empty($values['routing_number'])): ?>
				<routingNumber><?php echo Arr::get($values, 'routing_number', ''); ?></routingNumber>
<?php endif ?>
<?php if ( ! empty($values['account_number'])): ?>
				<accountNumber><?php echo Arr::get($values, 'account_number', ''); ?></accountNumber>
<?php endif ?>
<?php if ( ! empty($values['name_on_account'])): ?>
				<nameOnAccount><?php echo Arr::get($values, 'name_on_account', ''); ?></nameOnAccount>
<?php endif ?>
<?php if ( ! empty($values['echeck_type'])): ?>
				<echeckType><?php echo Arr::get($values, 'echeck_type', ''); ?></echeckType>
<?php endif ?>
			</bankAccount>
<?php endif ?>
		</payment>
<?php endif ?>
<?php if ( ! empty($values['invoice_number']) OR ! empty($values['description'])): ?>
		<order>
<?php if ( ! empty($values['invoice_number'])): ?>
			<invoiceNumber><?php echo $values['invoice_number']; ?></invoiceNumber>
<?php endif ?>
<?php if ( ! empty($values['description'])): ?>
			<description><?php echo $values['description']; ?></description>
<?php endif ?>
		</order>
<?php endif ?>
<?php if ( ! empty($values['cust_id']) OR ! empty($values['email']) OR ! empty($values['customer_phone']) OR ! empty($values['customer_fax'])): ?>
		<customer>
<?php if ( ! empty($values['cust_id'])): ?>
			<id><?php echo $values['cust_id']; ?></id>
<?php endif ?>
<?php if ( ! empty($values['customer_email'])): ?>
			<email><?php echo $values['customer_email']; ?></email>
<?php endif ?>
<?php if ( ! empty($values['customer_phone'])): ?>
			<phoneNumber><?php echo $values['customer_phone']; ?></phoneNumber>
<?php endif ?>
<?php if ( ! empty($values['customer_fax'])): ?>
			<faxNumber><?php echo $values['customer_fax']; ?></faxNumber>
<?php endif ?>
		</customer>
<?php endif ?>
<?php if ( ! empty($values['first_name'])
			OR ! empty($values['last_name'])
			OR ! empty($values['company'])
			OR ! empty($values['address'])
			OR ! empty($values['city'])
			OR ! empty($values['state'])
			OR ! empty($values['zip'])
			OR ! empty($values['country'])
			): ?>
		<billTo>
<?php if ( ! empty($values['first_name'])): ?>
			<firstName><?php echo $values['first_name']; ?></firstName>
<?php endif ?>
<?php if ( ! empty($values['last_name'])): ?>
			<lastName><?php echo $values['last_name']; ?></lastName>
<?php endif ?>
<?php if ( ! empty($values['company'])): ?>
			<company><?php echo $values['company']; ?></company>
<?php endif ?>
<?php if ( ! empty($values['address'])): ?>
			<address><?php echo $values['address']; ?></address>
<?php endif ?>
<?php if ( ! empty($values['city'])): ?>
			<city><?php echo $values['city']; ?></city>
<?php endif ?>
<?php if ( ! empty($values['state'])): ?>
			<state><?php echo $values['state']; ?></state>
<?php endif ?>
<?php if ( ! empty($values['zip'])): ?>
			<zip><?php echo $values['zip']; ?></zip>
<?php endif ?>
<?php if ( ! empty($values['country'])): ?>
			<country><?php echo $values['country']; ?></country>
<?php endif ?>
		</billTo>
<?php endif ?>
<?php if ( ! empty($values['ship_to_first_name'])
			OR ! empty($values['ship_to_last_name'])
			OR ! empty($values['ship_to_company'])
			OR ! empty($values['ship_to_address'])
			OR ! empty($values['ship_to_city'])
			OR ! empty($values['ship_to_state'])
			OR ! empty($values['ship_to_zip'])
			OR ! empty($values['ship_to_country'])
			): ?>
		<shipTo>
<?php if ( ! empty($values['ship_to_first_name'])): ?>
			<firstName><?php echo $values['ship_to_first_name']; ?></firstName>
<?php endif ?>
<?php if ( ! empty($values['ship_to_last_name'])): ?>
			<lastName><?php echo $values['ship_to_last_name']; ?></lastName>
<?php endif ?>
<?php if ( ! empty($values['ship_to_company'])): ?>
			<company><?php echo $values['ship_to_company']; ?></company>
<?php endif ?>
<?php if ( ! empty($values['ship_to_address'])): ?>
			<address><?php echo $values['ship_to_address']; ?></address>
<?php endif ?>
<?php if ( ! empty($values['ship_to_city'])): ?>
			<city><?php echo $values['ship_to_city']; ?></city>
<?php endif ?>
<?php if ( ! empty($values['ship_to_state'])): ?>
			<state><?php echo $values['ship_to_state']; ?></state>
<?php endif ?>
<?php if ( ! empty($values['ship_to_zip'])): ?>
			<zip><?php echo $values['ship_to_zip']; ?></zip>
<?php endif ?>
<?php if ( ! empty($values['ship_to_country'])): ?>
			<country><?php echo $values['ship_to_country']; ?></country>
<?php endif ?>
		</shipTo>
<?php endif ?>
	</subscription>
<?php endif ?>
</<?php echo $type; ?>>