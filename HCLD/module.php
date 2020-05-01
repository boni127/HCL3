<?php
	class HCLD extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$this->ConnectParent("{518933FA-6D8A-2ADA-5774-8413A058EA2A}");
			$this->RegisterVariableString("hcl_zwave_version", "Zwave-Version");
            $this->RegisterVariableString("hcl_zwave_company", "Zwave-Company");
            $this->RegisterVariableInteger("hcl_zwave_bright","BRIGHTNESS");
          
            $this->RegisterPropertyInteger("HclId",0);
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			$id= $this->ReadPropertyInteger("HclId");
			$this->SetReceiveDataFilter(".*\"HclId\":$id.*");
			parent::ApplyChanges();
		}

		public function Send(string $Text)
		{
			$Text .= $this->ReadPropertyInteger("HclId");
			$id= $this->ReadPropertyInteger("HclId");
			IPS_LogMessage("Device Send($id)", $Text);
			$this->SendDataToParent(json_encode(Array("DataID" => "{1590D5D7-2F2F-BF7F-3C3A-D9581874BF46}","Buffer" => $Text,"HclId"=>$id)));
		}

		public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString);
			$id= $this->ReadPropertyInteger("HclId");
			//$abc = $data->DevID;
			IPS_LogMessage("Device RECV($id)", utf8_decode($data->Buffer));
			IPS_LogMessage("Device RECV($id): HclId", utf8_decode($data->HclId));

		}

	}