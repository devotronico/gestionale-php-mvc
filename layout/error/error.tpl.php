<?php
return <<<HTML
<style>
.error__wrapper{
  z-index:10000;
  position:absolute;
  top:0;
  bottom:0;
  left:0;
  right:0;
  background:rgba(0,0,0,0.5);
}


/* <BTN-CLOSE> */
.error__close{
  position:relative;
  top:-5px;
  right:-260px;
  opacity:0.8;
  /* transition:all 200ms; */
  font-size:48px;
  font-weight:bold;
  text-decoration:none;
  color:#000;
}
.error__close:hover{opacity:1}
/* </BTN-CLOSE> */


/* <TABLE> */
.error__table {
  position: relative;
  margin: 100px auto;
  width: 600px;
  text-align: center;
  border-collapse: collapse;
  background: #A40808;
}

.error__th, .error__td {
  border: 1px solid rgba(0,0,0,.1);
  padding: 10px 5px;
}

.error__thead .error__th { padding: 0; }

.error__th {
  font-size: 18px;
  font-weight: bold;
  color: #FFFFFF;
  background: #A40808;
}

.error__td {
  font-size: 14px;
  background: #F5C8BF;
}

.error__tfoot .error__td { background: #A40808; }
</style>
<div class="error__wrapper">
    <table class="error__table">
        <thead class="error__thead">
            <tr class="error__tr">
            </tr>
            <th class="error__th" colspan="2">
                <a class="error__close" href="#">×
                </a>
            </th>
        </thead>
        <tbody class="error__tbody">
            <tr class="error__tr">
                <th class="error__th"></th>
                <th class="error__th">head</th>
            </tr>
            <tr class="error__tr">
                <th class="error__th">request</th>
                <td class="error__td">{$this->data['head']['request']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th">date</th>
                <td class="error__td">{$this->data['head']['date']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th">code</th>
                <td class="error__td">{$this->data['head']['code']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th">exception</th>
                <td class="error__td">{$this->data['head']['exception']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th">file</th>
                <td class="error__td">{$this->data['head']['file']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th">line</th>
                <td class="error__td">{$this->data['head']['line']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th">function</th>
                <td class="error__td">{$this->data['head']['function']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th">class</th>
                <td class="error__td">{$this->data['head']['class']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th">status</th>
                <td class="error__td">{$this->data['head']['status']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th">section</th>
                <td class="error__td">{$this->data['head']['section']}</td>
            </tr>
            <tr class="error__tr">
                <th class="error__th"></th>
                <th class="error__th">body</th>
            </tr>
            <tr class="error__tr">
                <th class="error__th">section</th>
                <td class="error__td">{$this->data['body']['message']}</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;
