## Function to return all widget packs that are required
function returnWidgetPacks($widgetValue, $packArr) {
	
	##Initialise return array
	$returnArr = array();
	
	## Sort array desc to cater for any additional pack sizes that could be added
	arsort($packArr);
	
	## Loop where widget value is greater than 0, decreasing it each time by the amount of a pack that gets selected
	for($i = $widgetValue; $i > 0; $i -= $val) {
		
		## Initialise vars
		$calculatedValArr = array();
		$metCriteria = false;
		
		## Cater for the largest package sizes
		if($i > (max($packArr) - min($packArr))) {
			if(!isset($returnArr[max($packArr)])) $returnArr[max($packArr)] = 0;
			$returnArr[max($packArr)]++;
			$val = max($packArr);
			$metCriteria = true;
			continue;
		}
		
		## Unset the largest package size from the array as we dont need it anymore
		unset($packArr[4]);
		
		## The remaining widgets requested must now be less than the maximum pack size
		foreach($packArr as $packSize) {
			
			## If the remaining number requested is less than the minimum pack size, add this to the array and break from the loop as this will be the last pack we need to add
 			if($i <= min($packArr)) {
				$val = min($packArr);
				if(!isset($returnArr[$val])) $returnArr[$val] = 0;
				$returnArr[$val]++;
				$metCriteria = true;
				break;
			}
			
			## If the remaining number is less than or equal to the current pack size, and it is greater than the pack size minus the minimum size, add this pack to the order 
			if($i <= $packSize && $i > ($packSize - min($packArr))) {
				$val = $packSize;
				if(!isset($returnArr[$val])) $returnArr[$val] = 0;
				$returnArr[$val]++;
				$metCriteria = true;
				continue;
			}

			## Calculate value for possible use outside of loop
			$calculatedValArr[abs($packSize-$i)] = $packSize ; 
			
		}
		
		## If the requested number did not meet any of the above criteria, loop through again 
		if(!$metCriteria) {
			foreach($packArr as $packSize) {
				## If the remaining number allows for others to be divided into it, take the largest whole number that does that (as array is in desc order)
				if(($i / $packSize) > 1) {
					$val = $packSize;
					if(!isset($returnArr[$val])) $returnArr[$val] = 0;
					$returnArr[$val]++;
					break;
				}
			}
		}

	}
	
	return $returnArr; 

}