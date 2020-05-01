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
		}

		public function ForwardData($JSONString)
		{
			$data = json_decode($JSONString);
			IPS_LogMessage("IO FRWD", utf8_decode($data->Buffer));
			$Text = 'Antwort vom IO';
			$this->SendDataToChildren(json_encode(Array("DataID" => "{D443C558-D963-4B2A-D017-B97CF576CB3A}", "Buffer" => $Text)));
		}

		public function Send(string $Text)
		{
			$this->SendDataToChildren(json_encode(Array("DataID" => "{D443C558-D963-4B2A-D017-B97CF576CB3A}", "Buffer" => $Text)));
		
			IPS_LogMessage("IO SEND", $Text);
		}

	}