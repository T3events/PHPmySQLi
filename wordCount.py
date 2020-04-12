# n top words from string
sentence = "Hello, place any string in here to use this program. Make sure to have at least one word that appears more than once in the string."
sentence = sentence.replace(".", "")
sentence = sentence.replace(",", "")

countsByWord = {}	
words = sentence.split() #make into dicionary

# loop over all, loop over just the uniques
for word in words:
	
	if word in countsByWord:
		countsByWord[word] = countsByWord[word] + 1
	else:
		countsByWord[word] = 1
        
wordcounts = []

for word in countsByWord:			
	count = countsByWord[word]
	wordcounts.append((count, word))
        
#change order to prep for n input

wordcounts.sort(reverse=True)

#x = len(wordcounts)
# get users number input

n = int(input("Enter in a number from 1 to 27: "))
#n = int(input("Enter in a number from 1 to" x ": "))
# Just grab the last n items 
topitems = wordcounts[:n]


for count, word in topitems:
	print(word)			

