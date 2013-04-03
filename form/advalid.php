<?php $title="复杂表单验证"?>
<?php include("../templates/header.php"); ?>  
  <div class="container">
    <div class="row">
      <div class="span8">
        <h2>简介</h2>
        <p>表单的<a class="page-action" data-id="valid" href="#">基本验证</a>已经讲过，这里对以下内容进行讲解：</p>
        <ol>
          <li>分组验证规则</li>
          <li>自定义验证规则</li>
          <li>自定义验证函数</li>
          <li>联合验证,可以添加在<a class="page-action" data-id="group" href="#">表单分组</a>中</li>
        </ol>
        <p>表单的异步验证请参看：<a class="page-action" data-id="remote" href="#">远程调用</a></p>
      </div>
      <div class="span16">
        <h2>表单分组的验证规则</h2>
        <p>多个字段的验证，需要添加在表单分组上，目前提供了3种表单分组的验证：</p>
         <ol>
          <li><code>dateRange</code>: 日期范围，一般使用 <code>dateRange : true</code>，如果开始时间和结束时间不能相等那么<code>dateRange : {equals:false}</code></li>
          <li><code>numberRange</code>: 数字范围,一般使用 <code>numberRange : true</code>，如果数字范围不能相等那么<code>numberRange : {equals:false}</code></li>
          <li><code>checkRange</code>: 勾选范围，使用方式：
            <ol>
              <li>checkRange : 1，checkRange : 2 ，如果参数是固定的数字n，那么代表，至少勾选n个选项</li>
              <li>checkRange : [2,2]: 如果参数是数组，而且相等，那么带便只能勾选n个选项</li>
              <li>checkRange : [2,4]: 如果参数是数组，而且是一个范围，那么需要勾选 m-n个选项 </li>
            </ol>
          </li>
        </ol>
        <form id="J_Form1" class="form-horizontal well">
          <div class="control-group">
            <label class="control-label">日期范围：</label>
            <div class="bui-form-group controls" data-rules="{dateRange : true}">
              <input name="start" type="text" class="calendar"/> - <input name="end" type="text" class="calendar"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">年龄范围：</label>
            <div class="bui-form-group controls" data-rules="{numberRange : {equals:false}}" data-messages="{numberRange:'结束年龄必须大于起始年龄！'}">
              <input name="start" type="number" class="input-small"/> - <input name="end" type="number" class="input-small"/>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label">勾选2个：</label>
            <div class="bui-form-group controls" data-rules="{checkRange:[2,2]}" data-messages="{checkRange:'只能选择2个'}">
              <label class="checkbox"><input name="ck" type="checkbox" value="1" />一</label>
              <label class="checkbox"><input name="ck" type="checkbox" value="2" />二</label>
              <label class="checkbox"><input name="ck" type="checkbox" value="3" />三</label>
              <label class="checkbox"><input name="ck" type="checkbox" value="4" />四</label>
              <label class="checkbox"><input name="ck" type="checkbox" value="5" />五</label>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">勾选2-4个：</label>
            <div class="bui-form-group controls" data-rules="{checkRange:[2,4]}" data-messages="{checkRange:'可以勾选{0}-{1}个选项！'}">
              <label class="checkbox"><input name="ck" type="checkbox" value="1" />一</label>
              <label class="checkbox"><input name="ck" type="checkbox" value="2" />二</label>
              <label class="checkbox"><input name="ck" type="checkbox" value="3" />三</label>
              <label class="checkbox"><input name="ck" type="checkbox" value="4" />四</label>
              <label class="checkbox"><input name="ck" type="checkbox" value="5" />五</label>
            </div>
          </div>
        </form>
        <pre class="prettyprint linenums">
&lt;div class="control-group"&gt;
  &lt;label class="control-label"&gt;日期范围：&lt;/label&gt;
  &lt;div class="bui-form-group controls" data-rules="{dateRange : true}"&gt;
    &lt;input name="start" type="text" class="calendar"/&gt; - &lt;input name="end" type="text" class="calendar"/&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;div class="control-group"&gt;
  &lt;label class="control-label"&gt;年龄范围：&lt;/label&gt;
  &lt;div class="bui-form-group controls" data-rules="{numberRange : true}"&gt;
    &lt;input name="start" type="number" class="input-small"/&gt; - &lt;input name="end" type="number" class="input-small"/&gt;
  &lt;/div&gt;
&lt;/div&gt;
 &lt;div class="control-group"&gt;
  &lt;label class="control-label"&gt;勾选2个：&lt;/label&gt;
  &lt;div class="bui-form-group controls" data-rules="{checkRange:[2,2]}" data-messages="{checkRange:'只能选择2个'}"&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="1" /&gt;一&lt;/label&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="2" /&gt;二&lt;/label&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="3" /&gt;三&lt;/label&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="4" /&gt;四&lt;/label&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="5" /&gt;五&lt;/label&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;div class="control-group"&gt;
  &lt;label class="control-label"&gt;勾选2-4个：&lt;/label&gt;
  &lt;div class="bui-form-group controls" data-rules="{checkRange:[2,4]}" data-messages="{checkRange:'可以勾选{0}-{1}个选项！'}"&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="1" /&gt;一&lt;/label&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="2" /&gt;二&lt;/label&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="3" /&gt;三&lt;/label&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="4" /&gt;四&lt;/label&gt;
    &lt;label class="checkbox"&gt;&lt;input name="ck" type="checkbox" value="5" /&gt;五&lt;/label&gt;
  &lt;/div&gt;
&lt;/div&gt;
        </pre>
      </div>
    </div>
    <div class="row">
      <div class="span8">
        <h2>自定义验证规则</h2>
        <p>在具体的业务场景中，可以自定义验证规则，可以定义2类验证规则：</p>
        <ol>
          <li>单个表单字段的验证规则</li>
          <li>表单分组的验证规则</li>
        </ol>
      </div>
      <div class="span16">
        <h2>自定义验证规则</h2>
        <p>自定义验证规则需要指定：</p>
        <ol>
          <li>name: 规则名称</li>
          <li>msg: 出错信息</li>
          <li>validator: 验证函数，函数原型： function(value,baseValue,formatMsg,control){}
            <ol>
              <li>value:验证的值,如果这个规则应用到分组上，那么value 就是一个键值对。</li>
              <li>baseValue: 在配置项中传入的值</li>
              <li>formatMsg: baseValue 替换msg模板中的数据，产生的错误信息。</li>
              <li>control: 应用规则到的控件，一般单个字段时不需要此参数。</li>
            </ol>
          </li>
        </ol>
        <form class="well" id="J_Form">
          <div>
            <label>学生编号：</label><input data-rules="{required:true,sid:5}" type="text">
          </div>
        </form>
        <h3>配置html</h3>
        <pre class="prettyprint linenums">
&lt;label&gt;学生编号：&lt;/label&gt;&lt;input data-rules="{required:true,sid:5}" type="text"&gt;          
        </pre>
        <h3>JS添加规则</h3>
        <pre class="prettyprint linenums">
          
Form.Rules.add({
  name : 'sid',
  msg : '请填写{0}数字的学生编号。',
  validator : function(value,baseValue,formatMsg){
    var regexp = new RegExp('^\\d{' + baseValue + '}$');
    if(value && !regexp.test(value)){
      return formatMsg;
    }
  }
});          
        </pre>
      </div>
    </div>
    <div class="row">
      <div class="span8">
        <h2>自定义验证函数</h2>
        <p>上面的验证规则适用于一类多次出现，复用率高的验证，而我们遇到更加复杂的业务验证时，需要设置验证函数</p>
        <p>验证函数可以用于2种情形：</p>
        <ol>
          <li>单个字段验证 </li>
         
          <li>多个字段验证，在<a class="page-action" data-id="group" href="#">表单分组</a>上或者整个表单上添加验证。
            
          </li>
        </ol>
      </div>
      <div class="span16">
        <h2>单个字段验证</h2>
        <p>单个字段验证，函数原型：function(value){return msg;}</p>
        <ol>
          <li>参数value : 验证的字段的值</li>
          <li>返回值msg:如果出错返回消息，否则返回null.</li>
        </ol>
        <form id="J_Form2" class="well">
          <div>
            <label>学生编号：</label><input name="studentId" type="text">
          </div>
        </form>
        <pre class="prettyprint linenums">
&lt;label&gt;学生编号：&lt;/label&gt;&lt;input name="studentId" type="text"&gt;
        </pre> 
        <pre class="prettyprint linenums">
//JS配置
new Form.Form({
  srcNode : '#J_Form2',
  validators : {
    'studentId' : function(value){ //读取input的表单字段 name
      if(!value){
        return '学生编号不能为空';
      }
      if(!/^$\d{5}$/.test(value)){
        return '学生编号为5位数字';
      }
    }
  }
}).render();
        </pre>
        <h2>多个字段验证</h2>
        <p>多个字段验证，函数原型：function(record){return msg;}</p>
        <ol>
          <li>参数record : 验证的字段组成的键值对。</li>
          <li>返回值msg:如果出错返回消息，否则返回null.</li>
        </ol>
        <form id="J_Form3" class="well">
          <div id="group" class="bui-form-group">
            <label>起始日期：</label>
            <input name="start" class="calendar" type="text"><label>&nbsp;-&nbsp;</label><input name="end" class="calendar" type="text">
          </div>
        </form>
        <pre class="prettyprint linenums">
&lt;form id="J_Form3" class="well"&gt;
  &lt;div id="group" class="bui-form-group"&gt;
    &lt;label&gt;起始日期：&lt;/label&gt;
    &lt;input name="start" class="calendar" type="text"&gt;&lt;label&gt;&nbsp;-&nbsp;&lt;/label&gt;&lt;input name="end" class="calendar" type="text"&gt;
  &lt;/div&gt;
&lt;/form&gt; 
        </pre> 
        <pre class="prettyprint linenums">
 new Form.Form({
  srcNode : '#J_Form3',
   //联合校验起始日期
  validators : {
    '#group' : function(record){//根据分组的id 
      if(record.start > record.end){
        return '结束日期必须大于起始日期！';
      }
    }
  }
}).render();
        </pre>        
      </div>
    </div>
  </div>
<?php include("../templates/script.php"); ?> 
<script type="text/javascript">
  BUI.use('bui/form',function (Form) {
    Form.Rules.add({
      name : 'sid',
      msg : '请填写{0}数字的学生编号。',
      validator : function(value,baseValue,formatMsg){
        var regexp = new RegExp('^\\d{' + baseValue + '}$');
        if(value && !regexp.test(value)){
          return formatMsg;
        }
      }
    });
    new Form.Form({
      srcNode : '#J_Form'
    }).render();

    new Form.HForm({
      srcNode : '#J_Form1'
    }).render();

    new Form.Form({
      srcNode : '#J_Form2',
      validators : {
        'studentId' : function(value){
          if(!value){
            return '学生编号不能为空';
          }
          if(!/^$\d{5}$/.test(value)){
            return '学生编号为5位数字';
          }
        }
      }
    }).render();

    new Form.Form({
      srcNode : '#J_Form3',
       //联合校验起始日期
      validators : {
        '#group' : function(record){
          if(record.start > record.end){
            return '结束日期必须大于起始日期！';
          }
        }
      }
    }).render();
  });
</script>
<?php include("../templates/footer.php"); ?>  