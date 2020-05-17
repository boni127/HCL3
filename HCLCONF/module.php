<?php
	class HCLK extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();
			$this->ConnectParent("{518933FA-6D8A-2ADA-5774-8413A058EA2A}");
			$this->RegisterPropertyInteger("PropertyCategoryID",0);
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

		public function GetConfigurationForm() {
			$Form = json_decode(file_get_contents(__DIR__ . '/form.json'), true);

			IPS_LogMessage("KonfigForm GetDevices()", '');

			// Kategorie im Baum suchen
			$parent= $this->ReadPropertyInteger("PropertyCategoryID");
			if (IPS_CategoryExists($parent)) {
				$tree_position[] = IPS_GetName($parent);
				while (1) {
					$parent = IPS_GetObject($parent)['ParentID'];
					if ($parent > 0 ) {
						array_unshift($tree_position ,IPS_GetName($parent));
						}  
					else {
						break;
						}  
					}
				}
			else {
				$tree_position=[];
				}
			// Devices vom HCL lesen
			$response = $this->SendDataToParent(json_encode(Array("DataID" => "{1590D5D7-2F2F-BF7F-3C3A-D9581874BF46}","Buffer" => json_encode(array('getDevices' => 1)),"HclId"=>'')));
			foreach (json_decode($response) as $entity) {
				IPS_LogMessage("HCLCONF return id", $entity->id);
				if ($entity->parentId>=1) {
					$AddValue = [
						'zid' => $entity->id,
						'name' => $entity->name,
						'company' =>  $entity->properties->zwaveCompany,
						'zwaveinfo' => $entity->properties->zwaveInfo,
						'softwareversion' => $entity->properties->zwaveVersion,
						'create' => [
							'moduleID' => '{5C71DE68-3DB9-2B14-58E3-C3A6D5A426C2}',
							'configuration' => [
									'HclId' => $entity->id,
									'zwaveCompany' => $entity->properties->zwaveCompany
							],
							'location' => $tree_position,
							]
						];
					$Form['actions'][0]['values'][] = $AddValue;
					}
				}	

			return json_encode($Form);
		}

	}

		