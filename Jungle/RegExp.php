<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 11.11.2015
 * Time: 15:52
 */
namespace Jungle {


	/**
	 * @PCRE-Modifiers
	 *
	 * @rules
	 *
	 * inner option (?i)
	 *
	 * not grab mask OR: (?:[abc]) , for inner option (?i:[abc]),  XOR : (?|(pat)tern|pa(tt)ern2)
	 *
	 * Recursion: (?R)
	 *
	 *  Comment: (#  )
	 *
	 * Reference: \4
	 *
	 * condition:                           (?(1)yes-pattern|no-pattern) (?(1)yes-pattern)
	 *
	 * Утверждения (После)look ahead:       subject(?=after)   , negated: subject(?!not-after)
	 * Утверждения (Перед)look behind:      (?<=before)subject   , negated: (?<!not-before)subject
	 *
	 * Однократная подмаска (Performance):  (?>\d+)
	 */





	/**
	 * Class RegExp
	 * @package Jungle
	 *
	 * * TODO TASK * * *
	 * Алиасы для [$i] индексных масок на приёме preg_match выборки значений
	 * Алиасы должны поддерживаться так-же preg_replace`м preg_replace_callback для генерирования callback по заданному
	 *     правилу Alias Рекурсивные RegExp не только по выражению но и программно через класс, чтобы умел строить
	 *     вложенные деревья Поддержка быстрого доступа и создания регулярок с ассоциативными ссылками Поддержка
	 *     итерирования множества результатов Возможность представлять результат каждого схождения шаблона , как объект
	 *      DataMapping
	 *
	 *
	 *
	 * В первую очередь из регекспа нам нужен единый интерфейс доступа к функционалу компонента
	 *
	 * Объект представляющий определенное регексп выражение
	 *
	 * Выражение одно и независимо от целей его определения:
	 *      Поиск по шаблону        (preg_match, preg_match_all).
	 *      Проверка соответствия   (preg_match, preg_match_all).
	 *      Замена по шаблону       (preg_replace, preg_replace_callback)
	 *      Разделение по шаблону   (preg_split)
	 *
	 * Объект представляющий результат для поиска по шаблону
	 *
	 */
	class RegExp{

		/** @var string */
		protected $delimiter = '@';

		/** @var string */
		protected $pattern  = null;

		/** @var string */
		protected $modifiers = '';

		/**
		 * @param $expression
		 */
		public function __construct($expression = null){}

		/**
		 * @param $pattern
		 * @return $this
		 */
		public function setPattern($pattern){
			$this->pattern = $pattern;
			return $this;
		}

		/**
		 * @return string
		 */
		public function getPattern(){
			return $this->pattern;
		}

		/**
		 * @param string $delimiter
		 * @return $this
		 */
		public function setDelimiter($delimiter = '@'){
			$this->delimiter = $delimiter;
			return $this;
		}

		/**
		 * @return string
		 */
		public function getDelimiter(){
			return $this->delimiter;
		}

		/**
		 * @param $modifiers
		 * @return $this
		 */
		public function setModifiers($modifiers){
			$this->modifiers = $modifiers;
			return $this;
		}

		/**
		 * @param $modifier
		 * @return $this
		 */
		public function addModifier($modifier){
			if(strpos($this->modifiers,$modifier) === false){
				$this->modifiers.=$modifier;
			}
			return $this;
		}

		/**
		 * @param $modifier
		 * @return bool|int
		 */
		public function searchModifier($modifier){
			return strpos($this->modifiers,$modifier);
		}

		/**
		 * @param $modifier
		 * @return $this
		 */
		public function removeModifier($modifier){
			$i = strpos($this->modifiers,$modifier);
			if($i !== false){
				substr_replace($this->modifiers,'',$i,1);
			}
			return $this;
		}

		/**
		 * @param string|string[] $subject
		 * @param string $delimiter
		 * @return string[]
		 */
		public static function pregQuoteArray($subject, $delimiter = '/'){
			if(is_array($subject)){
				foreach($subject as $i => $string){
					$subject[$i] = preg_quote($string,$delimiter);
				}
				return $subject;
			}else{
				return [preg_quote($subject,$delimiter)];
			}
		}


		/**
		 * @param $pattern
		 */
		public function find($pattern, $subject){

		}

		/**
		 * @param $pattern
		 */
		public function check($pattern){

		}

		/**
		 * @param $pattern
		 */
		public function replace($pattern){

		}

		/**
		 * @param $pattern
		 */
		public function split($pattern){

		}


		/**
		 * @return mixed
		 */
		public function getExpression(){
			return $this->patterns;
		}


		/**
		 *
		 */
		public function reset(){

		}

		/**
		 *
		 */
		public function toArray(){
			/**
			$a = [];
			if($this->result_collection){
				$c = count($this->result[0]);
				for($i = 1; $i < $c; $i++){
					$current = &$a[($i - 1)] = [];
					if($this->assoc){
						foreach($this->assoc as $key){
							$current[$key] = $this->result[$key][$i];
						}
					}else{
						$current = $this->result[$i];
					}
				}
			}else{
				if($this->assoc){
					foreach($this->assoc as $key){
						$current[$key] = $this->result[$key];
					}
				}else{
					//$current = $this->error[$i];
				}
			}*/
		}




		/**
		 * @param bool|true $on
		 * @return RegExp
		 *  /m (@PCRE_MULTILINE) По умолчанию PCRE обрабатывает данные как однострочную символьную строку (даже если она
		 *     содержит несколько разделителей строк). Метасимвол начала строки '^' соответствует только началу
		 *     обрабатываемого текста, в то время как метасимвол "конец строки" '$' соответствует концу текста, либо
		 *     позиции перед завершающим текст переводом строки (в случае, если модификатор D не установлен). В Perl
		 *     ситуация полностью аналогична. Если этот модификатор используется, метасимволы "начало строки" и "конец
		 *     строки" также соответствуют позициям перед произвольным символом перевода и строки и, соответственно,
		 *     после, как и в самом начале и в самом конце строки. Это соответствует Perl-модификатору /m. В случае,
		 *     если обрабатываемый текст не содержит символов перевода строки, либо шаблон не содержит метасимволов '^'
		 *     или '$', данный модификатор не имеет никакого эффекта.
		 */
		public function multiline($on = true){
			return $on?$this->addModifier('m'):$this->removeModifier('m');
		}

		/**
		 * @param bool|true $on
		 * @return RegExp
		 * /s (@PCRE_DOTALL) Если данный модификатор используется, метасимвол "точка" в шаблоне соответствует всем
		 *     символам, включая перевод строк. Без него - всем, за исключением переводов строк. Этот модификатор
		 *     эквивалентен записи /s в Perl. Класс символов, построенный на отрицании, например [^a], всегда
		 *     соответствует переводу строки, независимо от наличия этого модификатора.
		 */
		public function dotall($on = true){
			return $on?$this->addModifier('s'):$this->removeModifier('s');
		}

		/**
		 * @param bool|true $on
		 * @return RegExp
		 * /i (@PCRE_CASELESS) Если этот модификатор используется, символы в шаблоне соответствуют символам как
		 *     верхнего, так и нижнего регистра.
		 */
		public function caseless($on = true){
			return $on?$this->addModifier('i'):$this->removeModifier('i');
		}

		/**
		 * @param bool|true $on
		 * @return RegExp
		 * /x (@PCRE_EXTENDED) Если используется данный модификатор, неэкранированные пробелы, символы табуляции и пустой
		 *     строки будут проигнорированы в шаблоне, если они не являются частью символьного класса. Также
		 *     игнорируются все символы между неэкранированным символом '#' (если он не является частью символьного
		 *     класса) и символом перевода строки (включая сами символы '\n' и '#'). Это эквивалентно Perl-модификатору
		 *     /x, и позволяет размещать комментарий в сложных шаблонах. Замечание: это касается только символьных
		 *     данных. Пробельные символы не фигурируют в служебных символьных последовательностях, к примеру, в
		 *     последовательности '(?(', открывающей условную подмаску.
		 */
		public function extended($on = true){
			return $on?$this->addModifier('x'):$this->removeModifier('x');
		}

		/**
		 * @param bool|true $on
		 * @return RegExp
		 * /A (@PCRE_ANCHORED) Если используется данный модификатор, соответствие шаблону будет достигаться только в том
		 *     случае, если он "заякорен", т.е. соответствует началу строки, в которой производится поиск. Того же
		 *     эффекта можно достичь подходящей конструкцией с вложенным шаблоном, которая является единственным
		 *     способом реализации этого поведения в Perl.
		 */
		public function anchored($on = true){
			return $on?$this->addModifier('A'):$this->removeModifier('A');
		}

		/**
		 * @param bool|true $on
		 * @return RegExp
		 * /D (@PCRE_DOLLAR_ENDONLY) Если используется данный модификатор, метасимвол $ в шаблоне соответствует только
		 *     окончанию обрабатываемых данных. Без этого модификатора метасимвол $ соответствует также позиции перед
		 *     последним символом, в случае, если им является перевод строки (но не распространяется на любые другие
		 *     переводы строк). Данный модификатор игнорируется, если используется модификатор m. В языке Perl
		 *     аналогичный модификатор отсутствует.
		 */
		public function dollar_end_only($on = true){
			return $on?$this->addModifier('D'):$this->removeModifier('D');
		}

		/**
		 * @param bool|true $on
		 * @return RegExp
		 * /S    В случае, если планируется многократно использовать шаблон, имеет смысл потратить немного больше времени
		 *     на его анализ, чтобы уменьшить время его выполнения. В случае, если данный модификатор используется,
		 *     проводится дополнительный анализ шаблона. В настоящем это имеет смысл только для "незаякоренных"
		 *     шаблонов, не начинающихся с какого-либо определенного символа.
		 */
		public function cached($on = true){
			return $on?$this->addModifier('S'):$this->removeModifier('S');
		}

		/**
		 * @param bool|true $on
		 * @return RegExp
		 * /U (@PCRE_UNGREEDY) Этот модификатор инвертирует жадность квантификаторов, таким образом они по умолчанию не
		 *     жадные. Но становятся жадными, если за ними следует символ ?. Такая возможность не совместима с Perl.
		 *     Его также можно установить с помощью (?U) установки модификатора внутри шаблона или добавив знак вопроса
		 *     после квантификатора (например, .*?).
		 */
		public function ungreddy($on = true){
			return $on?$this->addModifier('U'):$this->removeModifier('U');
		}

		/**
		 * @param bool|true $on
		 * @return RegExp
		 * /X (@PCRE_EXTRA) Этот модификатор включает дополнительную функциональность PCRE, которая не совместима с Perl:
		 *     любой обратный слеш в шаблоне, за которым следует символ, не имеющий специального значения, приводят к
		 *     ошибке. Это обусловлено тем, что подобные комбинации зарезервированы для дальнейшего развития. По
		 *     умолчанию же, как и в Perl, слеш со следующим за ним символом без специального значения трактуется как
		 *     опечатка. На сегодняшний день это все возможности, которые управляются данным модификатором
		 */
		public function extra($on = true){
			return $on?$this->addModifier('X'):$this->removeModifier('X');
		}

		/**
		 * @param bool|true $on
		 * @return RegExp
		 * /u (@PCRE_UTF8) Этот модификатор включает дополнительную функциональность PCRE, которая не совместима с Perl:
		 *     шаблон и целевая строка обрабатываются как UTF-8 строки. Модификатор u доступен в PHP 4.1.0 и выше для
		 *     Unix-платформ, и в PHP 4.2.3 и выше для Windows платформ. Валидность UTF-8 в шаблоне и целевой строке
		 *     проверяется начиная с PHP 4.3.5. Недопустимая целевая строка приводит к тому, что функции preg_* ничего
		 *     не находят, а неправильный шаблон приводит к ошибке уровня E_WARNING. Пятый и шестой октеты UTF-8
		 *     последовательности рассматриваются недопустимыми с PHP 5.3.4 (согласно PCRE 7.3 2007-08-28); ранее они
		 *     считались допустимыми.
		 */
		public function unicode($on = true){
			return $on?$this->addModifier('u'):$this->removeModifier('u');
		}


	}
}

