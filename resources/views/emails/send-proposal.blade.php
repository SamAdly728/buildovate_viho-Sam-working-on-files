<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{!! env('ICON') !!}" type="image/x-icon">
    <link rel="shortcut icon" href="{!! env('ICON') !!}" type="image/x-icon">
    <!-- <title>viho - Premium Admin Template</title> -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <style>
      body{
      width: 650px;
      /* font-family: work-Sans, sans-serif; */
      font-family: Helvetica,Arial,'Lucida Grande',sans-serif;
      background-color: #f6f7fb;
      display: block;
      }
      a{
      text-decoration: none;
      }
      span {
      font-size: 14px;
      }
      p {
          font-size: 13px;
         line-height: 1.7;
         letter-spacing: 0.7px;
         margin-top: 0;
      }
      .text-center{
      text-align: center
      }
    </style>
  </head>
  <body style="margin: 30px auto;">
    <table style="width: 100%">
      <tbody>
        <tr>
          <td>
            <table style="background-color: #f6f7fb; width: 100%">
              <tbody>
                <tr>
                  <td>
                    <table style="width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px">
                      <tbody>
                        <tr>
                          <td style="padding: 30px"> 
                            <h4>Hi {!! $DISPLAY_NAME !!},</h4>
                            <p>We're thriled to share the next step in bringing your vision to life!</p>
                            <p><b>Your personalized proposal from {!! $COMPANY_NAME !!} is ready for review</b></p>
                            <p><b>Key highlights of your proposal: </b></p>
                            <ul>
                                <li><p style="margin-bottom: 3px;">Custom design tailored to your space.</p></li>
                                <li><p style="margin-bottom: 3px;">Detailed project timeline and milestones.</p></li>
                                <li><p style="margin-bottom: 3px;">Clear and competitive pricing.</p></li>
                                <li><p style="margin-bottom: 3px;">High-quality materials for lasting enjoyment.</p></li>
                                <li><p style="margin-bottom: 3px;">Our commitment to craftmanship and excellence.</p></li>
                            </ul>
                            <p>Ready to see what we've envisioned for your project? Just click below and dive in:</p>
                            <a href="{!! env('EMAIL_URL') !!}/guest/proposal-preview?code={!! $CODE !!}" target="_blank" style="padding: 10px; background-color: #24695c; color: #ffffff; display: inline-block; border-radius: 4px; margin-bottom: 18px">
                                Review Proposal
                            </a>
                            <p>(You might need to sign into your Buildovate account to view the proposal details.)</p>
                            <p>If you have any question or would like to discuss the details further, we're just a message or call away. We're excited to make your project a reality.</p>
                            <br><br>
                            <p style="margin-bottom: 0px;">Warm regards,</p>
                            <p style="margin-bottom: 0px;">{!! $SEND_BY !!}</p>
                            <p>{!! $COMPANY_NAME !!}</p><br>
                            <p>P.S. <i>We believe in a world where every detail counts, especially when it's your home. Let's build something beautiful together.</i></p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                   
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>