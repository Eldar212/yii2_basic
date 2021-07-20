api-create-migrate:
	./yii migrate/create ${name} --migrationPath=@app/modules/api/v${version}/${module}/migrations
