#!/bin/bash
# Jenkins 部署代码.

# variable define
send_mail_url='http://yj.dfwgame.com/h5agency/phpTransfer/gameApi.php?service=ApiPublic.SendEmail.Send'
feishu_notice_url='http://yj.dfwgame.com/h5agency/phpTransfer/gameApi.php?service=ApiPublic.Feishu.BotPublish'
mail_title=""
project_id=""

# 读取参数开始 ---------------------------
string=$1
array=(${string//,/ })

for var in ${array[@]}
do
	array2=(${var//:/ })
	field=${array2[0]}
	value=${array2[1]}

	if [ $field = "folder_name" ]
	then
		folder_name=$value
	fi

	if [ $field = "parent_dir" ]
	then
		parent_dir=$value
	fi

	if [ $field = "user_email" ]
	then
		user_email=$value
	fi

	if [ $field = "mail_title" ]
	then
		mail_title=$value
	fi

	if [ $field = "tag" ]
	then
		tag=$value
	fi

	if [ $field = "project_id" ]
	then
		project_id=$value
	fi

	if [ $field = "env" ]
	then
		env=$value
	fi

	if [ $field = "desc" ]
	then
		desc=$value
	fi
done
# 读取参数结束 ---------------------------


local_ip=$(curl -s whatismyip.akamai.com)
project_path=${parent_dir}'/'${folder_name}
op_path=${project_path}'/bin'
run_pull_file='./run_pull.txt'
log_file_path="./git_pull.out"

# 读取临时文件的内容(可累加)
function readFileContent(){
  con=""
  while read line
  do
  	con="$con""$line""<br>"
  done  < ${run_pull_file}

  echo $con
}

# operate ------------------------------------------------------
DATE=`date '+%Y%m%d-%H%M%S'`

cd $op_path
echo "operate"
echo " " >> ${log_file_path}
echo "———————————————–" >> ${log_file_path}
echo $(date +"%Y-%m-%d %H:%M:%S")" start operate" >> ${log_file_path}

if [ "$env" == "prod" ]; then
  cd ../
  git checkout .
  cd $op_path
fi
if [ "$tag" == "" ]; then
  # 进行最新代码部署
  if [ "$env" == "prod" ]; then
    git checkout master
  fi

  echo "所处分支:" > ${run_pull_file}
  git branch >> ${run_pull_file}
  echo " " >> ${run_pull_file}
  git pull >> ${run_pull_file}

  raw_content=$(cat ${run_pull_file})

  content=$(readFileContent "")

  echo ${raw_content}
  echo ${raw_content} >> ${log_file_path} 2>&1 &

  # 检查代码是否冲突			-------------------
  long_str=$raw_content""
  findStr="Fast-forward"
  find_res=$(echo $long_str | grep "${findStr}")
  if [[ "$find_res" != "" ]]
  then
  	key_title="更新完成"
  else
  	findStr="Already up-to-date"
  	find_res=$(echo $long_str | grep "${findStr}")
  	if [[ "$find_res" != "" ]]
  	then
  	  key_title="无更新内容"
  	else
  	  key_title="代码冲突"
  	fi
  fi
  # 检查代码是否冲突 结束		-------------------
else
  # 进行回滚
  git pull origin master:$tag > ${run_pull_file}
  git branch -d $tag
  git checkout $tag

  raw_content=$(cat ${run_pull_file})

  echo ${raw_content}
  echo ${raw_content} >> ${log_file_path} 2>&1 &

  # 判断回滚状况
  echo "所处分支:" >> ${run_pull_file}
  git branch >> ${run_pull_file}
  temp_c=$(cat ${run_pull_file})
  long_str=$temp_c""
  find_str="HEAD detached at "$tag
  find_res=$(echo $long_str | grep "${find_str}")
  if [[ "$find_res" != "" ]]
  then
      key_title="回滚:"$tag"完成"
  else
      key_title="回滚:"$tag"失败"
  fi

  content=$(readFileContent "")
fi

# 如果没有传递通知标题, 自行拼装
if [ "$mail_title" == "" ]; then
    mail_title="${local_ip}-${folder_name}-${key_title}"
fi

# 拼接正文
final_content=${desc}"<br>"${local_ip}" - "${folder_name}"<br>"${key_title}"<br>"${content}
# 解决加号丢失的问题
rep_content=${final_content//+/%2b}

# 邮件通知
curl ${send_mail_url} -X POST -d "addresses=${user_email}&title=${mail_title}:&content=${rep_content}"

# 飞书通知
if [ "$project_id" != "" ]; then
  curl ${feishu_notice_url} -X POST -d "robot_type=web&project_id=${project_id}&content=${rep_content}"
fi

echo "deploy complete"
