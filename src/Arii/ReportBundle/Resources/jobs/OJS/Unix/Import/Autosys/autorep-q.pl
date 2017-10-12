#!/usr/bin/perl
# Transformation d'un autorep -q
#
@Rules = (
#	'job_name|^(\w*?)(\w)\.|application,env',
	'job_name|^(SE)\.|application=Administration,env=P',
	'job_name|^(A)(\w)\.|application=AIA v3.1,env',
	'job_name|^(B)(\w)\.|application=BI,env',
	'job_name|^(BI_)(\w)\.|application=BI,env',
	'job_name|^(CNT)(\w)\.|application=Connectique,env',
	'job_name|^(D)(\w)\.|application=Datawarehouse (Oracle),env',
	'job_name|^(DCT)(\w)\.|application=Documentum,env',
	'job_name|^(E)(\w)\.|application=Eire,env',
	'job_name|^(EXP)(\w)\.|application=Exploitation,env',
	'job_name|^(F)(\w)\.|application=Finter,env',
	'job_name|^(G)(\w)\.|application=AIA v2,env',
	'job_name|^(H)(\w)\.|application=Editique,env',
	'job_name|^(HA_)(\w)\.|application=Haute dispo.,env',
	'job_name|^(I)(\w)\.|application=Infocentre,env',
	'job_name|^(L)(\w)\.|application=Logic,env',	
	'job_name|^(MFT)(\w)\.|application=Transferts,env',
	'job_name|^(OC)\.|application=Context,env=P',
	'job_name|^(ORA)(\w)\.|application=Oracle,env',
	'job_name|^(PDT)(\w)\.|application=Poste de travail,env',
	'job_name|^(PT)(\w)\.|application=Poste de travail,env',
	'job_name|^(R)(\w)\.|application=Finter,env',
	'job_name|^(SUN)(\w)\.|application=Sunnet,env',
	'job_name|^(SHR)(\w)\.|application=SharePoint,env',
	'job_name|^(TST)(\w)\.|application=Tests divers,env',
	'job_name|^(WCR)(\w)\.|application=WIncredit,env',
	'job_name|^(V)([PT])\.|application=Valorlife,env',
	'job_name|^(VM)\.|application=Véhicule Moteur,env=P',
	'job_name|^(Z)(\w)\.|application=HR Access,env'	
);

$source = 'ATS' unless $source=$ARGV[0];
	
@Cols = ('job_name','job_type','box_name','machine','owner','watch_file','command','description','application','env');
print "spooler_name\t".join("\t",@Cols)."\n";
while (<STDIN>) {
	chomp;	
	s/[\n\r]$//;
	s/^\s*//;
	s/\s*$//;
	next if /^$/;
	next if /^\s\/*/;
	if (/^insert_job: (.*?) \s*job_type: (\w*)/) {
		$job = $1;
		$Job{$job}->{'job_name'} = $job;
		$Job{$job}->{'job_type'} = $2;
	}
	elsif (/(\w*?): (.*)/) {
		$var = $1;
		$val = $2;
		$val =~ s/"$//;
		$val =~ s/^"//;
		$Job{$job}->{$var} = $val;

	}
}

foreach my $job (sort keys %Job) {
	DisplayJob($job);
}

sub DisplayJob {
my($job) = @_;

	$info = $job;
	$info =~ s/^SE\./ADMP./;
	if ($info =~ /(\w*)(P|T|I)\./) {
		$app = $1;
		$Job{$job}->{'env'} = $2;
	}
	if ($App{$app}) {
		$Job{$job}->{'application'} = $App{$app};
	}
	else {
		$Job{$job}->{'application'} = $app;
	}

	# Application des règles
	foreach (@Rules) {
		my($source,$rule,$target) = split('\|');
		my @Found = ($Job{$job}->{$source} =~ /${rule}/);
		if ($#Found>0) {
			$n=0;
			foreach (split(',',$target)) {
				if (/=/) {
					my($var,$val) = split(/=/);
					$Job{$job}->{$var} = $val;
					# print "$source,$rule,$target $var = $val\n";
				}
				else {
					$Job{$job}->{$_} = $Found[$n];
					# print "$source,$rule,$target $_ = ".$Found[$n]."\n";
				}
				$n++;
			}
		}
	}
	
	print "$source";
	foreach $k (@Cols) {
		print "\t".$Job{$job}->{$k};	
	}
	print "\n";
}
