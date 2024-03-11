import express from 'express';
import cors from 'cors';
import bodyParser from 'body-parser';
import dotenv from 'dotenv';
import { Configuration, PlaidApi, PlaidEnvironments } from 'plaid';


dotenv.config();
const PORT = process.env.PORT

const configuration = new Configuration({
  basePath: PlaidEnvironments.sandbox,
  baseOptions: {
    headers: {
      'PLAID-CLIENT-ID': process.env.PLAID_CLIENT_ID,
      'PLAID-SECRET': process.env.PLAID_SECRET,
      'Plaid-Version': '2020-09-14'
    },
  },
});

const plaidClient = new PlaidApi(configuration);

const app = express();
app.use(cors());
app.use(bodyParser.json());

app.post('/create_link_token', async function (request, response) {
  const plaidRequest = {
    user: {
      client_user_id: 'user',
    },
    client_name: 'Plaid Test App',
    products: ['auth', 'transactions'],
    language: 'en',
    redirect_uri: `${process.env.APP_URL}:${PORT}/`,
    country_codes: ['US'],
  };
  try {
    const createTokenResponse = await plaidClient.linkTokenCreate(plaidRequest);
    
    console.log('Plaid link-token:', createTokenResponse.data.link_token); // Log the whole response

    if (createTokenResponse) {
      response.json({
        link_token: createTokenResponse.data.link_token, // assuming the response contains "link_token"
      });
    } else {
      console.error('No response received from Plaid CREATE LINK.');
      response.status(500).send('No response from Plaid API.');
    }
  } catch (error) {
    console.error('Error calling Plaid linkTokenCreate:', error); // Log the error
    response.status(500).send('Error creating link token.');
  }
});


app.post('/auth', async function(request, response){
    try{
        const access_token = request.body.access_token;
        const plaidRequest = {
            access_token: access_token,
        };
        const plaidResponse = await plaidClient.authGet(plaidRequest);
        response.json(plaidResponse.data);
    }catch(e){
        response.status(500).send("failed");
    }
});

app.post('/transaction_sync', async function(request, response){
    try{
        const access_token = request.body.access_token;
        // const start_date = request.body.start_date;
        // const end_date = request.body.end_date;
        const plaidRequest = {
            access_token: access_token
            // start_date: start_date,
            // end_date: end_date,
        };
        const plaidResponse = await plaidClient.transactionsSync(plaidRequest);
        if (plaidResponse) {
          response.json(plaidResponse.data);
        }else{
          response.status(500).json(plaidResponse);
        }
    }catch(e){
        response.status(500).send("failed");
    }
});

app.post('/transaction_get', async function(request, response){
    try{
        const access_token = request.body.access_token;
        const plaidRequest = {
            access_token: access_token,
            start_date: '2023-01-01',
            end_date: '2023-07-05',
            options: {
                include_personal_finance_category: true
            },
        };
        const plaidResponse = await plaidClient.transactionsGet(plaidRequest);
        response.json(plaidResponse.data);
    }catch(e){
        response.status(500).send("failed");
    }
});

app.post('/exchange_public_token', async function ( request, response, next, ) {
  console.log('Plaid exchange_public_token:', request.body.public_token);
    const publicToken = request.body.public_token;
    try {
      const plaidResponse = await plaidClient.itemPublicTokenExchange({
        public_token: publicToken,
      });
      console.log('Plaid access-token:', plaidResponse); // Log the whole response

      if (plaidResponse) {
        response.json({
          access_token: plaidResponse.data.access_token, // assuming the response contains "access_token"
        });
      } else {
        console.error('No response received from Plaid EXCHANGE.');
        response.status(500).send('No response from Plaid API.');
      }
    } catch (error) {
      const responseJSON = error.response;
      console.log('Plaid error:', responseJSON.data.error_code);
      if(responseJSON.data.error_code){
        let message = 'No message available for error code: ' + responseJSON.data.error_code;

        if(responseJSON.data.error_message){
          message = responseJSON.data.error_message;
        }
        response.json({
          error_code: responseJSON.data.error_code,
          message: message
        });
      }else{
        response.status(500).send(error);
      }
    }
});

app.listen(PORT, '0.0.0.0', () => {
  console.log(`Server running using EXPRESS at :${PORT}/`);
});