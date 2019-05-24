<?php
/**
 *  superSimpleMediaBrowser
 * Simple class to browse folders for media files, and return the founded files.
  *  Author : Leif Nesheim (gitleif)
 *  Url: https://github.com/gitleif/superSimpleMediaBrowser
 * Created: 2019-05-25
 *  Version: 0.0.1
 */

 class superSimpleMediaBrowser
 {
        public $AllowedFiles = array("jpg","jpeg");
        public $PublicRoot = null; // the public url that match the localroot: e.g http://localhost/
        public $SubFolder = null; //
        public $MediaDataFileFolder = null;
        public $PublicSub = "";
        public $FallbackURL = "";
        private $_BaseArray = null;
        
        function __construct($UrlRoot, $SubFolderInRoot, $FallbackURL = null)
        {
            $this->PublicRoot = $UrlRoot;
            $this->PublicSub  = $SubFolderInRoot;
            $this->MediaDataFileFolder = $_SERVER['DOCUMENT_ROOT'] . $_SERVER["REDIRECT_URL"];
            $nearest = $this->fixFilepath($this->findMediaDataFile(  $this->MediaDataFileFolder ));
            $tmp = $_SERVER['DOCUMENT_ROOT'] . $this->PublicSub;
            $tmpnew = str_replace($nearest, "", $this->fixFilepath($this->MediaDataFileFolder));
            $this->SubFolder = trim($tmpnew,"/");

            $BaseRoot = $_SERVER['DOCUMENT_ROOT'] . $this->PublicSub;
            $BaseUrl = $this->PublicRoot . $this->PublicSub;
            $Mappe = $this->fixFilepath($_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI']);
            $BaseFolder = str_replace($BaseRoot,"", $Mappe);
            $Mappe = $BaseRoot . $BaseFolder;
            
            $this->_BaseArray = explode('/', $BaseFolder);
            $this->_BaseArray = array_filter($this->_BaseArray);
         
            if($this->_BaseArray!=null && empty($this->_BaseArray)==false && isset($this->_BaseArray[0]))
            {
              $this->BaseImageURL = $BaseUrl . $this->_BaseArray[0] . "/";
              }
              
              $this->FallbackURL = $FallbackURL;
        }
    
        
       

    
        // this will search for and parse media file in $Folder
        // Returns null or array with selected files.
        public function parseMediaDataFile()
        {
              $fallbackChecked = false;
             $checkFolder = $this->MediaDataFileFolder;             
            $File = $this->findMediaDataFile($checkFolder);
            if($File!=null)
            {                
                $XX = $this->readDataFile($File);
                return(($this->parseDataFile($XX, $this->SubFolder)));
            }
            return null;
        }

        
        // this function opens mediaDataFile in $Folder.
        // reads every line and return an php array or null,
        public function readDataFile($Folder)
        {
                // check if data.php exist in $Folder
                $file = $Folder . DIRECTORY_SEPARATOR . "data.php";
                if(file_exists($file))
                {
                           require_once($file);
                           return($Data);
                }
                // Did not find data.php
                return null;
        }
    
       // Returns the subfolders used in the url
       // if index = null all folders are returned
       public function getFolders($index = null)
       {
              if($index!==null)
              {
                     
                     if(isset($this->_BaseArray[$index]))
                     {
                            return $this->_BaseArray[$index];
                     }
                     return null;
              }
              else
              {
                     return($this->_BaseArray);
              }
       }
       
        
        // This will search $Folder for files and build the required
        // datastructure file in php format.
        // The datastructurefile must be updated each time files have been added to the $Folder.
        public function buildMediaDataFile($Folder, $saveDataFile = false)
        {
            // Check if folder exist
            if(is_dir($Folder)==true)
            {
                $array = null;
                $xPath = str_replace('/',DIRECTORY_SEPARATOR, $Folder);
                
                foreach($this->getDirContents($Folder) as $item)
                {
                        $parts=pathinfo($item);
                        
                        if(in_array($parts['extension'], $this->AllowedFiles))
                        {
                                    $tmp =str_replace($xPath, "" , $item);
                                    $array[] = str_replace($Folder, "" , $tmp);
                        }
                }
                
                if($saveDataFile==true && $array!=null)
                {
                    return($this->saveMediaDataFile($array, $Folder));                    
                }                
                return $array;
            }
            echo("Folder not found");
            return null;
        }
        
        // Function to save the data structure file correctly
        // returns true or false.
        public function saveMediaDataFile($Files, $Folder)
        {
            // Creating the mediaDataFile from all of the Files found
            // in the $Folder.
               $txt[] = "<?php";
               $txt[] = '// mediaDatafile create by the supersimplemediabrowser';
               $txt[] = '// Build Folder : ' . $Folder;
               $txt[] = '// Files Found : ' . count($Files);
               $txt[] = '// Build Date : ' . date("Y-m-d");
               
               foreach($Files as $file)
               {
                   $txt[] = utf8_encode("\$Data[] = array('File'=>'" . $file . "','Url'=>'');");
               }
               $txt[] = "?>";
               // Skriv innholder til fila
               $file = fopen($Folder . "data.php","w");
               fwrite($file,implode(PHP_EOL, $txt));
               fclose($file);
               return true;
        }
        
        // Internal function to recurrsive scan folder and subfolders for all files.
        // found: https://stackoverflow.com/questions/24783862/list-all-the-files-and-folders-in-a-directory-with-php-recursive-function/24784144
        private function getDirContents($dir, &$results = array())
        {
            $files = scandir($dir);
                foreach($files as $key => $value)
                {
                    $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
                    if(!is_dir($path) )
                    {
                        $results[] = $path;
                    } else if($value != "." && $value != "..")
                    {
                        $this->getDirContents($path, $results);
                    }
                }
            return $results;
        }
        
        // Internal function to read the datamediafile
        private function parseDataFile($FilesFound, $subfolder)
        {
        	$_isSubFolder = false;
        	if(strlen($subfolder)!=0 OR $subfolder!=null)
        	{
        		$_isSubFolder = true;
        	}
            
            $ret = null;
            foreach($FilesFound as $item)
            {
                $tmpFile = substr($item['File'], 0, strlen($subfolder));
                
                if($tmpFile==$subfolder)
                {
                    $_add = true;
                    
                    if($_isSubFolder==false && strpos($item['File'], DIRECTORY_SEPARATOR) !== false)
                    {
                        $_add = false;
                    }

                        
                    if($_add==true)
                    {
                        $item['baseurl'] = $this->BaseImageURL . $item['File'];
                        $ret[] = $item;
                    }
                }
            }
            
            return($ret);		
       }
       
       // Search after data.php in StartPath, if not found search next folder.
        // End at root.
        // Returns path to mediaDataFile or Null if not found
        private function findMediaDataFile($StartPath)
        {
            $Max = count(explode("/" , $StartPath));
            $i = 0;
            $Continue = true;
            $tmpPath = $StartPath;
            while($Continue == true)
            {
                if(file_exists($tmpPath . "/data.php"))
                {
                    return($tmpPath);
                }
                else
                {
                        $tokens = explode('/', $tmpPath);
                        array_pop($tokens);   
                        $tmpPath = implode('/', $tokens);   // wrap back                                        
                }
                
                $i++;
                if($i>=$Max)
                {
                    $Continue = false;
                }
            }
            return null;
        }

       
    
       // internal function to remove double slashes from filename
       private function fixFilepath($txt)
        {
            return(str_replace("//","/",$txt));
        }
        

 }
 



?>