<?php
return <<<HTML
<html style="margin:0;padding:0;font-family:sans-serif;color:#333;background-color:#000">
<style>
#button:hover { color:red }
</style>
    <body style="margin:0;padding:0;background-color:#333">
    <style>
#button:hover { color:green }
</style>
        <table width="580" cellpadding="0" cellspacing="0" style="margin:0 auto;background-color:blue">
            <tbody>
                <tr>
                    <td colspan="4" style="height:100px;text-align:center;background-color:$this->bgColor1">
                        <a href="$this->site" style="display:block;text-align:center" target="_blank">
                            <img src="$this->image1Tpl" height="32" alt="$this->site">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="height:100px;text-align:center;background-color:$this->bgColor2">
                        <img alt="email" width="80" src="$this->image2Tpl">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="height:100px;text-align:center;background-color:$this->bgColor2">
                        <span style="color:$this->txtColor1;font-size:24px">$this->titleTpl</span>
                        <hr style="margin:10px auto;width:90%;opacity:0.5">
                        <p style="color:$this->txtColor2;font-size:12px;font-style:italic">$this->info1Tpl</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="height:100px;text-align:center;background-color:$this->bgColor2">
                        <a href="$this->link" id="button" style="display:block;width:70%;margin:0 auto;padding:15px 0;background-color:$this->btnBgColor1;color:$this->btnTxtColor1;border-radius:3px;text-decoration:none" target="_blank">$this->buttonTpl</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="height:100px;text-align:center;background-color:$this->bgColor2">
                        <p style="color:$this->txtColor2;font-size:12px;line-height:17px;font-style:italic">$this->info2Tpl</p>
                        <p style="color:$this->txtColor2;font-size:12px;line-height:17px;font-style:italic">$this->info3Tpl</p>
                        <a href="$this->link" style="display:block;padding:10px;font-size:12px;" target="_blank">$this->link</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="height:50px;text-align:center;background-color:$this->bgColor1">
                        <p style="color:$this->txtColor2;font-size:12px;line-height:17px;font-style:italic">$this->info4Tpl</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:100px;text-align:center;background-color:$this->bgColor1">
                        <span>
                            <a href="" target="_blank">
                                <img src="https://i.imgur.com/hPqFLPE.png" height="40" alt="iOS app mobile">
                            </a>
                        </span>
                    </td>
                    <td colspan="2" style="height:100px;text-align:center;background-color:$this->bgColor1">
                        <span>
                            <a href="" target="_blank">
                                <img src="https://i.imgur.com/k6mZR2h.png" height="40" border="0" alt="Android app mobile">
                            </a>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="height:30px;text-align:center;background-color:$this->bgColor1">
                        <a href="$this->site" style="color:$this->txtColor2;text-decoration:none" target="_blank">&copy; $this->site 2019</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
HTML;






