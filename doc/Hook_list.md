
admin.field 自动生成HOOK相关说明：

  admin.field.form  $form   
  表单
  
  admin.field.index $db_object 
  自动表单列表，QUERY
  
  
  admin.field.before_save 
  保存数据前
  
  admin.field.insert  $data
  添加数据后 其中 _result 这个key 是写入数据库返回的insert i
  
  admin.field.update $data
  更新数据后 其中 _result 这个key 是写入数据库返回的insert id
  
  admin.field.save $data
  添加或更新数据后 其中 _result 这个key 是写入数据库返回的insert id
