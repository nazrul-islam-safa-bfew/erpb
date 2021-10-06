<?php



        class PageNavigation {

                /* Global Variables */

                //----------------------------------

                var $totalResults;//Total results returned from query
                var $resultsPerPage;//How many search items will be displayed per each page
                var $page;//The current page we are showing
                var $pages;//Total pages - determined by $totalResults and $resultsPerPage
                var $startHTML; //Example: "Showing Page 1 of 5: Go to Page: "
                var $appendSearch; //Example: "&a=1&b=2" - if you have other get vars that need to be shown besides &page=
                var $range; //How many numbers will be shown - plus and minus of the page we are on
                var $link_on;//Example: "<a href='testpage.php'><b>6</b></a>" - notice bold
                var $link_off;//Example: "<a href='testpage.php'>6</a>" - without bold
                var $back;//Example: "<a href='1.php'>FIRST</a>" - first page
                var $forward;//Example: "<a href='50.php'>LAST</a>" - last page


                var $product;//The final result





                /* String Aliases */

                //----------------------------------

                //  While the product is being built, there will be alias variables that we will do a search/replace for
                //  Example: "&page={page}"; where {page} might become "1"

                //Here are the allowed aliases

                //  {page} will become $page//global var
                //{pages} will become $pages//global var
                //  {num} will become $num//local var
                //{appendSearch} will become $appendSearch//global var




                //----------------------------------


                /****************************************
                *                                       *
                *Constructor                         *
                *                                       *
                *****************************************/

                function PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward) {

                        $this->totalResults = $totalResults;
                        $this->resultsPerPage = $totalResults;
                        $this->page = $page;
                        $this->pages = ceil($totalResults / $resultsPerPage);

                        // Example of $startHTML: "Showing Page {page} of {pages}: Go to Page:"
                        $this->product = $startHTML;
                        $this->appendSearch = $appendSearch;
                        $this->range = $range;
                        $this->link_on = $link_on;
                        $this->link_off = $link_off;
                        $this->back = $back;
                        $this->forward = $forward;


                }

                /****************************************
                *                                       *
                *Replace Alias                       *
                *                                       *
                *****************************************/

                function replace_alias() {

                        //  {page} = $page//global var
                        //{pages} = $pages//global var
                        //{appendSearch} = $appendSearch//global var

                        $this->product = str_replace("{page}", $this->page, $this->product);
                        $this->product = str_replace("{pages}", $this->pages, $this->product);
                        $this->product = str_replace("{appendSearch}", $this->appendSearch, $this->product);

                }


                /****************************************
                *                                       *
                *GET HTML                            *
                *                                       *
                *****************************************/

                function getHTML() {

                        //array of html links for each number
                        $pageLinks = array();

                        //loop array of needed pages
                        for ($i=0;$i<$this->pages;$i++) {

                                //This is the current number we are on
                                $num = $i+1;

                                //Is this page within our 'range'
                                $showNum = false;

                                if ($this->page >= $num && $this->page - $this->range <= $num)
                                $showNum = true;


                                if ($this->page <= $num && $this->page + $this->range >= $num)
                                $showNum = true;


                                if ($showNum == true) {
                                        if (($num) == $this->page) {
                                                array_push($pageLinks, str_replace("{num}", $num, $this->link_on));
                                        } else {
                                                array_push($pageLinks, str_replace("{num}", $num, $this->link_off));
                                        }
                                }

                        }



                        //Determine if we need BACK link
                        if (($this->page - $this->range) > 1)
                        $this->product .= $this->back;

                        //Turn array of html numbre-links into one string
                        $this->product .= implode(" | ",$pageLinks);

                        //Determine if we need FORWARD link
                        if (($this->page + $this->range) < $this->pages)
                        $this->product .= $this->forward;



                        //Do Replacements
                        $this->replace_alias();


                        //Return Final Product
                        return $this->product;


                }







                /****************************************
                *                                       *
                *END CLASS                           *
                *                                       *
                *****************************************/
        }




?>
