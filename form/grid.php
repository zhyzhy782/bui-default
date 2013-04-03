<?php $title="可编辑表格"?>
<?php include("../templates/header.php"); ?>  
  <div class="container">
    <div id="grid"></div>
    <p>
      <button id="btnSave" class="button button-primary">提交</button>
    </p>
    <h2>提交结果</h2>
    <div class="row">
      <div id="log" class="well span12">

      </div>
    </div>
    <hr>
    <div class="row">
      <div class="span8">
        <h2>简介</h2>
        <p>可编辑表格在表单中经常使用，用于编辑列表信息。有以下需要处理的点：</p>
        <ol>
          <li>编辑器 ： 不同类型的数据需要不同类型的编辑器，各类编辑器的配置项也有差异，验证信息需要配置在编辑器中。</li>
          <li>添加操作 ：添加数据时有2点需要注意：
            <ol>
              <li>字段的默认值</li>
              <li>添加数据的位置，最前面还是最后面</li>
            </ol>
          </li>
          <li>删除操作：可以批量删除或者单行删除</li>
          <li>提交表格数据</li>
        </ol>
      </div>
      <div class="span16">
        <h2>编辑器</h2>
        <p>编辑器在列定义时配置，使用<code>editor : {}</code>格式，其中的对象是编辑数据的字段的配置，可参看：<a href="http://http://www.builive.com//docs/#!/api/BUI.Form.Field" target="_blank">表单字段</a></p>
        <p>编辑器的类型常使用<code>xtype</code>指定，常用类型如下：</p>
        <ol>
          <li><code>text</code> : 文本输入框，参看：<a href="http://http://www.builive.com//docs/#!/api/BUI.Form.Field.Text" target="_blank">表单文本字段</a></li>
          <li><code>number</code> : 数字，参看：<a href="http://http://www.builive.com//docs/#!/api/BUI.Form.Field.Number" target="_blank">表单数字字段</a>,常见配置项
            <ol>
              <li><code>min</code> : 最小值</li>
              <li><code>max</code> : 最大值</li>
              <li><code>allowDecimals</code> : 允许小数，默认 true</li>
            </ol>
          </li>
          <li><code>date</code> : 日期，参看<a href="http://http://www.builive.com//docs/#!/api/BUI.Form.Field.Date" target="_blank">表单日期字段</a>，常见配置：
            <ol>
              <li><code>min</code> : 最小日期</li>
              <li><code>max</code> : 最大日期</li>
              <li><code>showTime</code> : 是否选择时、分、秒</li>
            </ol>
          </li>
          <li><code>select</code> :选择框，参看<a href="http://http://www.builive.com//docs/#!/api/BUI.Form.Field.Select" target="_blank">表单选择框字段</a>常见配置：
            <ol>
              <li><code>items</code> : 选择列表的选项，支持的格式 [{text : 'a',value:'a'},{text : 'b',value:'b'}]，或者 {a : 'a',b : 'b'}
              </li>
               
            </ol>
          </li>
        </ol>
        <p>
          <span class="label label-warning">注意</span>：日期类型可以接受 字符串，数字(date.getTime())或者日期类型，但是返回类型全部是以数字类型返回,所以建议日期类型的初始类型也是数字格式。

        </p>
      </div>
    </div>
    <div class="row">
      <div class="span8">
        <h3>验证</h3>
        <p>可以在编辑器中配置验证信息，支持2中方式：</p>
        <ol>
          <li>rules : 验证规则，参看:<a class="page-action" data-id="valid" href="#">表单基础验证</a></li>
          <li>validator : 自定义验证函数，函数原型：function(value,obj){}</li>
        </ol>
      </div>
      <div class="span16">
        <h3>示例</h3>
        <pre class="prettyprint linenums">
var columns = [
  //文本编辑器，必填  
  {title : '学校名称',dataIndex :'school',editor : {xtype : 'text',rules:{required:true}}},
  //日期编辑器
  {title : '入学日期',dataIndex :'enter',editor : {xtype : 'date'},renderer : Grid.Format.dateRenderer},//使用现有的渲染函数，日期格式化
  //日期编辑器，自定义验证函数
  {title : '毕业日期',dataIndex :'outter',editor : {xtype : 'date',validator : function(value,obj){
    if(obj.enter && value && obj.enter > value){
      return '毕业日期不能晚于入学日期！'
    }
  }},renderer : Grid.Format.dateRenderer},
  {title : '备注',dataIndex :'memo',width:200,editor : {xtype : 'text'}}
];
        </pre>
      </div>
    </div>
    <div class="row">
      <div class="span8">
        <h2>生成表格</h2>
        <p>生成表格需要配置以下内容：</p>
        <ol>
          <li>列配置</li>
          <li>初始化数据 </li>
          <li>数据缓冲类</li>
          <li>表格配置</li>
          <li>单元格编辑插件</li>
        </ol>
      </div>
      <div class="span16">
        <h3>代码</h3>
        <p>列配置在此处代码上面</p>
        <pre class="prettyprint linenums">
//默认的数据
var data = [//日期数据以数字格式提供，为了使传入传出数据格式一致，返回值为date.getTime()生成的数字
    {id:'1',school:'武汉第一初级中学',enter:936144000000,outter:993945600000,memo:'表现优异，多次评为三好学生'},
    {id:'2',school:'武汉第一高级中学',enter:999561600000,outter:1057017600000,memo:'表现优异，多次评为三好学生'}
  ],
  //数据缓冲类
  store = new Data.Store({
    data:data
  }),
  //单元格编辑插件
  editing = new Grid.Plugins.CellEditing(),
  //表格配置
  grid = new Grid.Grid({
    render : '#grid',
    columns : columns,
    width : 700,
    forceFit : true,
    store : store,
    plugins : [Grid.Plugins.CheckSelection,editing],
    tbar:{
        items : [{
          btnCls : 'button button-small',
          text : '&lt;i class="icon-plus"&gt;&lt;/i&gt;添加',
          listeners : {
            'click' : addFunction
          }
        },
        {
          btnCls : 'button button-small',
          text : '&lt;i class="icon-remove"&gt;&lt;/i&gt;删除',
          listeners : {
            'click' : delFunction
          }
        }]
    }

  });
grid.render();
        </pre>
      </div>
    </div>
    <div class="row">
      <div class="span8">
        <h2>其他操作</h2>
        <p>表格的编辑操作可以直接点击单元格进行编辑，通过验证保存到表格中。</p>
        <ol>
          <li>添加和删除操作需要自定义函数，在上面的按钮栏上注册了<code>addFunction</code>和<code>delFunction</code>事件处理函数</li>
          <li>提交表格数据，可以异步提交表格，或者将表格数据保存到表单的隐藏域中，进行提交，提交前，进行表格验证。 </li>
        </ol>
      </div>
      <div class="span16">
        <h3>添加，删除</h3>
        <pre class="prettyprint linenums">
//添加记录
function addFunction(){
  var newData = {school :'请输入学校名称'};
  store.add(newData);//如果指定添加的位置，使用 store.addAt(newData,index);
  editing.edit(newData,'school'); //添加记录后，直接编辑
}
//删除选中的记录
function delFunction(){
  var selections = grid.getSelection();
  store.remove(selections);
}          
        </pre>
        <h3>提交数据</h3>
        <p>本页未提供表单，所以，直接把数据显示出来。</p>
        <pre class="prettyprint linenums">
var logEl = $('#log');
$('#btnSave').on('click',function(){
  if(editing.isValid()){ //判断是否通过验证，如果在表单中，那么阻止表单提交
    var records = store.getResult();
    logEl.text(BUI.JSON.stringify(records));
  }
});          
        </pre>
      </div>
    </div>
  </div>
<?php include("../templates/script.php"); ?> 
<script type="text/javascript">
  BUI.use(['bui/grid','bui/data'],function (Grid,Data) {

    var columns = [{title : '学校名称',dataIndex :'school',editor : {xtype : 'text',rules:{required:true}}},
            {title : '入学日期',dataIndex :'enter',editor : {xtype : 'date',rules:{required:true}},renderer : Grid.Format.dateRenderer},//使用现有的渲染函数，日期格式化
            {title : '毕业日期',dataIndex :'outter',editor : {xtype : 'date',rules:{required:true},validator : function(value,obj){
              if(obj.enter && value && obj.enter > value){
                return '毕业日期不能晚于入学日期！'
              }
            }},renderer : Grid.Format.dateRenderer},
            {title : '备注',dataIndex :'memo',width:200,editor : {xtype : 'text'}}
            
          ],
      //默认的数据
      data = [{id:'1',school:'武汉第一初级中学',enter:936144000000,outter:993945600000,memo:'表现优异，多次评为三好学生'},
    {id:'2',school:'武汉第一高级中学',enter:999561600000,outter:1057017600000,memo:'表现优异，多次评为三好学生'}],
      store = new Data.Store({
        data:data
      }),
      editing = new Grid.Plugins.CellEditing(),
      grid = new Grid.Grid({
        render : '#grid',
        columns : columns,
        width : 700,
        forceFit : true,
        store : store,
        plugins : [Grid.Plugins.CheckSelection,editing],
        tbar:{
            items : [{
              btnCls : 'button button-small',
              text : '<i class="icon-plus"></i>添加',
              listeners : {
                'click' : addFunction
              }
            },
            {
              btnCls : 'button button-small',
              text : '<i class="icon-remove"></i>删除',
              listeners : {
                'click' : delFunction
              }
            }]
        }

      });
    grid.render();

    function addFunction(){
      var newData = {school :'请输入学校名称'};
      store.add(newData);
      editing.edit(newData,'school'); //添加记录后，直接编辑
    }

    function delFunction(){
      var selections = grid.getSelection();
      store.remove(selections);
    }
    var logEl = $('#log');
    $('#btnSave').on('click',function(){
      if(editing.isValid()){
        var records = store.getResult();
        logEl.text(BUI.JSON.stringify(records));
      }
    });
  });
</script>
<?php include("../templates/footer.php"); ?> 