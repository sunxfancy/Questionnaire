Question
========

这是一个在线问答系统

当进入student的欢迎界面是，会设置stu_id参数，将此参数保留在cookie中，用于拼接cookie的键值
survey 需要一个参数isfirst,赋值为1或者2,为1时表示为点击开始答题按钮..为2时表示下一题按钮...其余参数会被阻止
survey 会被设置参数testinfo(见library中SurveyResult详细说明),其中cookie中答案键值需要设置为stu_id-testinfo.cur形式