import express from 'express'
import { getPersonalInfo, getSingleInfo, createPersonalInfo } from './database.js'
import path from 'path'
import moment from 'moment'

const app = express()

app.use(express.json())

app.use(express.static(path.join(process.cwd(), 'public')))


    app.get("/", (req, res) => {
        res.sendFile(path.join(process.cwd(), 'public', 'index.html'))
    });

    app.get("/info", async (req, res) =>{
        const info = await getPersonalInfo()
        res.send(info)
    })


    app.get("/info/:id", async (req, res) =>{
        const id = req.params.id
        const infoid = await getSingleInfo(id)
        res.send(infoid)
    })

    app.post("/info", async (req, res) => {
        const { first_name, last_name, e_mail, phone_number, birth_date } = req.body;

        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (e_mail && !emailRegex.test(e_mail)) {
            return res.status(400).json({ message: "Ugyldig e-mail. Du må ha med @" })
        }

        const phoneRegex = /^(9|4)\d{7}$/;
        if (!phoneRegex.test(phone_number)) {
            return res.status(400).json({ message:"Ugyldig telefonnummer. Det skal være 8 tall, og starte med enten 9 eller 4." })
        }
    
        const birthDateRegex = /^\d{8}$/ 
        if (!birthDateRegex.test(birth_date)) {
            return res.status(400).json({ message: 'Ugyldig fødselsdato. Bruk DDMMYYYY.' })
        }

        // Convert the birth date to the proper format using moment
        const birthDateMoment = moment(birth_date, 'DDMMYYYY', true)
        if (!birthDateMoment.isValid()) {
            return res.status(400).json({ message: 'Ugyldig fødselsdato.' })
        }

        const age = moment().diff(birthDateMoment, 'years');
        if (age < 16) {
            return res.status(400).json({ message: 'Du må være minst 16 år gammel.' })
        }

        const birthDateForDB = birthDateMoment.format('YYYY-MM-DD');
        const infoid = await createPersonalInfo(first_name, last_name, e_mail, phone_number, birthDateForDB)
        res.status(201).send(infoid)
    });

    app.use((err, req, res, next) => {
        console.error(err.stack)
        res.status(500).send('Something broke!')
        })

        app.listen(8080, () => {
        console.log('Server is running on port 8080')
        })