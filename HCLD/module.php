<?php
	class HCLD extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$this->ConnectParent("{518933FA-6D8A-2ADA-5774-8413A058EA2A}");
			$this->RegisterVariableString("ZwaveVersion", "Zwave-Version");
			$this->RegisterVariableInteger("Brightness","Brightness");
			$this->RegisterVariableBoolean("State","State",'~Switch');
			          
			$this->RegisterPropertyInteger("HclId",0);
			$this->RegisterPropertyString("zwaveCompany",'');
		
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
			//$this->SetReceiveDataFilter(".*\"HclId\":$id.*");

			$this->EnableAction("State");
            $valuesId = $this->GetIDForIdent("State");
			parent::ApplyChanges();
			IPS_LogMessage("HCLD Apply valuesID",$valuesId);
		}

		public function Send(string $Text)
		{
			$Text .= $this->ReadPropertyInteger("HclId");
			$id= $this->ReadPropertyInteger("HclId");
			IPS_LogMessage("HCLD Send($id)", $Text);
			$a= $this->SendDataToParent(json_encode(Array("DataID" => "{1590D5D7-2F2F-BF7F-3C3A-D9581874BF46}","Buffer" => $Text,"HclId"=>$id)));
			IPS_LogMessage("HCLD return($id)", $a);
		}


		public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString);
			$id= $this->ReadPropertyInteger("HclId");
			IPS_LogMessage("HCLD RECV($id)", utf8_decode($data->Buffer));
			IPS_LogMessage("HCLD RECV($id): HclId", utf8_decode($data->HclId));

		}

		public function RequestAction($Ident, $Value) {
			IPS_LogMessage("HCLD RequestAction","$Ident: $Value");
			switch($Ident) {
				case "State":
					SetValue($this->GetIDForIdent($Ident), $Value);
					if ($Value) {
						$payload = json_encode(array('action' => 'turnOn'));
					} else {
						$payload = json_encode(array('action' => 'turnOff'));
					}
					break;
				default:
					throw new Exception("Invalid Ident");
				}
			$response = $this->SendDataToParent(json_encode(Array("DataID" => "{1590D5D7-2F2F-BF7F-3C3A-D9581874BF46}","Buffer" => $payload,"HclId"=>$this->ReadPropertyInteger("HclId"))));
		    IPS_LogMessage("HCLD response:",$response);
		}

	}