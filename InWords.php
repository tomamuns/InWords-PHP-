<?php
class InWords
{
	private $_fixed_numerals_bangla 			= array ("শূন্য", "এক ", "দুই ", "তিন ", "চার ", "পাঁচ ", "ছয় ", "সাত ", "আট ", "নয় ", "দশ ", "এগারো ", "বারো ", "তেরো ", "চৌদ্দ ", "পনেরো ", "ষোল ", "সতেরো ", "আঠারো ", "ঊনিশ ", "বিশ ", "একুশ ", "বাইশ ", "তেইশ ", "চব্বিশ ", "পঁচিশ ", "ছাব্বিশ ", "সাতাশ ", "আঠাশ ", "ঊনত্রিশ ", "ত্রিশ ", "একত্রিশ ", "বত্রিশ ", "তেত্রিশ ", "চৌত্রিশ ", "পঁয়ত্রিশ ", "ছত্রিশ ", "সাইত্রিশ ", "আটত্রিশ ", "ঊনচল্লিশ ", "চল্লিশ ", "একচল্লিশ ", "বিয়াল্লিশ ", "তেতাল্লিশ ", "চুয়াল্লিশ ", "পঁয়তাল্লিশ ", "ছেচল্লিশ ", "সাতচল্লিশ ", "আটচল্লিশ ", "ঊনপঞ্চাশ ", "পঞ্চাশ ", "একান্ন", "বাহান্ন", "তিপ্পান্ন", "চুয়ান্ন", "পঞ্চান্ন", "ছাপ্পান্ন", "সাতান্ন", "আটান্ন", "উনষাইট", "ষাইট", "একষাট্টি", "বাষট্টি", "তেষট্টি", "চৌষট্টি", "পঁয়ষট্টি", "ছেষট্টি", "সাতষট্টি", "আটষট্টি", "উনসত্তর", "সত্তর", "একাত্তর", "বাহাত্তর", "তিয়াত্তর", "চুয়াত্তর", "পঁচাত্তর", "ছিয়াত্তর", "সাতাত্তর", "আটাত্তর", "উনআশি", "আশি", "একাশি", "বিরাশি", "তিরাশি", "চুরাশি", "পঁচাশি", "ছিয়াশি", "সাতাশি", "আটআশি", "উননব্বই", "নব্বই", "একানব্বই", "বিরানব্বই", "তিরানব্বই", "চুরানব্বই", "পঁচানব্বই", "ছিয়ানব্বই", "সাতানব্বই", "আটানব্বই", "নিরানব্বই");
	
	private $_fixed_numerals_english            = array("Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen");
    
	private $_fixed_numerals_20_30_40_english   = array ("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty ", "Ninety ");
		
	function GetBanglaWord(string $_str_num)
    {
		$_len = strlen($_str_num);
		if ($_len < 1 || $_len > 2)
		{
			return "";
		}
		$_num = $_str_num + 0;
		return trim($this->_fixed_numerals_bangla[$_num])."";
	} //end method
		
	function GetWord(string $_str_num)
    {
		$_len = strlen($_str_num);
		if ($_len < 1 ||$_len > 2)
		{
			return "";
		}
		$_num = $_str_num + 0;
		
		if ($_num > 0 && $_num < 20)
		{
			return trim($this->_fixed_numerals_english[$_num])."";
		}
		else if ($_num >= 20 && $_num <= 99)
		{
			$_1_ind = floor($_num / 10) + 0;
			$_2_ind = $_num % 10 + 0;
			
			$_tmp_str = trim($this->_fixed_numerals_20_30_40_english[$_1_ind])."";
			if ($_2_ind != 0)
			{
				$_tmp_str .= " ".trim($this->_fixed_numerals_english[$_2_ind])."";
			}
			return $_tmp_str;
		}
		return "";
	} //end method
		
	function InWord(string $number, int $len, int $depth, string $words, bool $and_flg, bool $and_done, bool $is_english = true)
	{
		if ($len > -1)
        {
			$digit_position = 0;

			if ($depth == 2 || $depth == 6)
			{
				$digit_position = substr($number,$len, 1) + 0;
				$len = $len - 1;
			}
			else if ($len - 1 > -1)
			{
				$digit_position = substr($number,$len - 1, 2) + 0;
				$len = $len - 2;
			}
			else
			{
				$digit_position = substr($number,$len, 1) + 0;
				$len = $len - 2;
			}

			$tmp_words = "";
			$_tmp_numeral = "";
			$_tmp_and = "";

			if ($digit_position > 0)
			{
				switch ($depth)
				{
					case 2:
					case 6:
						$_tmp_numeral = $is_english == true ? " Hundred " : "শ ";
						break;
					case 3:
					case 7:
						$_tmp_numeral = $is_english == true ? " Thousand " : " হাজার ";
						break;
					case 4:
					case 8:
						$_tmp_numeral = $is_english == true ? " Lac " : " লাখ ";
						break;
					case 5:
						$_tmp_numeral = $is_english == true ? " Crore ": " কোটি ";
						break;
					default:
						$_tmp_numeral = " ";
						break;
				}
				if ($is_english == true && $and_flg == true && $and_done == false)
				{
					$_tmp_and = " and ";
					$and_done = true;
				}
				$sub_tmp_words = $is_english == true ? $this->GetWord(trim($digit_position)."") : $this->GetBanglaWord(trim($digit_position)."");
				$tmp_words = $sub_tmp_words.$_tmp_numeral.$_tmp_and.$words;
				$and_flg = true;
			}
			else
			{
				$tmp_words = $words;
			}
			return $this->InWord($number, $len, $depth + 1, $tmp_words, $and_flg, $and_done, $is_english);
		}
		return $words;
	}
}
?>