import mysql from 'mysql2'

 const pool = mysql.createPool({
      host: '127.0.0.1',
      user: 'root',
      password: 'nynur559',
      database: 'registration_schema'
}).promise()

const result = await pool.query("SELECT * FROM personal_information")
console.log(result)