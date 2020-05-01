<?php
	class HCLSPLIT extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$this->RequireParent("{0BE7FA45-4866-1A55-2736-D0CAB9C70680}");
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
			IPS_LogMessage("Splitter FRWD", utf8_decode($data->Buffer));

			$this->SendDataToParent(json_encode(Array("DataID" => "{6DEAE164-60E6-BF7A-53B7-A24588741E4D}","Buffer" => $data->Buffer,"HclId" => $data->HclId)));

			return "String data for device instance!";
		}

		public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString);
			IPS_LogMessage("Splitter RECV", utf8_decode($data->Buffer));
			$this->SendDataToChildren(json_encode(Array("DataID" => "{66D69490-42AD-A343-0F75-185A31AA08BA}","Buffer" => $data->Buffer,"HclId" => $data->HclId)));
		}

	}