# https://pypi.org/project/td-ameritrade-python-api/

# import the TD Ameritrade client
from td.client import TDClient

# Create a new session, credentials path is required.
TDSession = TDClient(
    client_id='78Z3JQGFXAVRCV35NZWZIEB3KAFRL1O0',
    redirect_uri='http://localhost/',
    credentials_path='td_state.json'
)

print("Connecting to TD Ameritrade...")

# Login to the session
TDSession.login()

# Grab real-time quotes for 'MSFT' (Microsoft)
msft_quotes = TDSession.get_quotes(instruments=['MSFT'])

# Grab real-time quotes for 'AMZN' (Amazon) and 'SQ' (Square)
# multiple_quotes = TDSession.get_quotes(instruments=['AMZN','SQ'])

print(msft_quotes)
