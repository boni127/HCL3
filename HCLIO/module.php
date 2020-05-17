<?php
	class HCLIO extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();
			$this->RegisterPropertyString('Host', '');
            $this->RegisterPropertyString('User', '');
			$this->RegisterPropertyString('Password', '');
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();
			IPS_LogMessage("HCLIO ","apply changes");

		}

		public function ForwardData($JSONString)
		{
			$data = json_decode($JSONString);
			$Payload = json_decode($data->Buffer);

			if (isset($Payload->action) AND isset($data->HclId)) {
				IPS_LogMessage("HCLIO: ","http://".$this->ReadPropertyString("Host")."/api/devices/26/action/".$Payload->action);
				$curl = curl_init(); 
				curl_setopt_array($curl, array( 
					CURLOPT_URL => "http://".$this->ReadPropertyString("Host")."/api/devices/26/action/".$Payload->action, 
					CURLOPT_RETURNTRANSFER => true, 
					CURLOPT_TIMEOUT        => 5,
					CURLOPT_CONNECTTIMEOUT => 5,
					CURLOPT_POSTFIELDS => '',
					CURLOPT_HTTP_VERSION => "HTTP/1.1", 
					CURLOPT_POST => 1,
					CURLOPT_USERPWD => $this->ReadPropertyString("User").':'.$this->ReadPropertyString("Password"),
					CURLOPT_HTTPHEADER => array('Content-Type: application/json')
					)); 
				$response = curl_exec($curl); 
				curl_close($curl);
				
				return($response);

			}

			if (isset($Payload->getDevices)) {
				IPS_LogMessage("HCLIO: ","http://".$this->ReadPropertyString("Host")."/api/devices");
				$curl = curl_init(); 
				curl_setopt_array($curl, array( 
					CURLOPT_URL => "http://".$this->ReadPropertyString("Host")."/api/devices/", 
					CURLOPT_RETURNTRANSFER => true, 
					CURLOPT_TIMEOUT        => 5,
					CURLOPT_CONNECTTIMEOUT => 5,
					CURLOPT_HTTP_VERSION => "HTTP/1.1", 
					CURLOPT_USERPWD => $this->ReadPropertyString("User").':'.$this->ReadPropertyString("Password"),
					CURLOPT_HTTPHEADER => array('Content-Type: application/json')
					)); 
				$response = curl_exec($curl); 
				curl_close($curl);
				IPS_LogMessage("HCLIO getDevices: Finish",'');
				return($response);
			}
			return;
}

		public function Send(string $Text)
		{
			$this->SendDataToChildren(json_encode(Array("DataID" => "{D443C558-D963-4B2A-D017-B97CF576CB3A}", "Buffer" => $Text)));
		
			IPS_LogMessage("HCLIO SEND", $Text);
		}

	}